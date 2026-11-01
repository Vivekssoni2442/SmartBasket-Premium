package com.smartbasket.deliveryboy;

import android.Manifest;
import android.content.Intent;
import android.app.Activity;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.view.Gravity;
import android.text.InputType;
import android.webkit.GeolocationPermissions;
import android.webkit.PermissionRequest;
import android.webkit.WebChromeClient;
import android.webkit.WebResourceError;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends Activity {
    private static final int LOCATION_PERMISSION_REQUEST = 41;
    private static final String PREFS = "delivery_app";
    private static final String LINK_KEY = "driver_link";

    private LinearLayout root;
    private WebView webView;
    private GeolocationPermissions.Callback pendingGeoCallback;
    private String pendingGeoOrigin;
    private EditText linkInput;

    @Override
    protected void onCreate(Bundle state) {
        super.onCreate(state);
        Uri incoming = getIntent() == null ? null : getIntent().getData();
        String link = validDriverLink(incoming == null ? null : incoming.toString());
        if (link == null) {
            link = validDriverLink(getPreferences(MODE_PRIVATE).getString(LINK_KEY, ""));
        }

        if (link == null) {
            showLinkSetup();
        } else {
            openDriver(link);
        }
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        setIntent(intent);
        Uri incoming = intent == null ? null : intent.getData();
        String link = validDriverLink(incoming == null ? null : incoming.toString());
        if (link != null) openDriver(link);
    }

    private String validDriverLink(String value) {
        if (value == null || value.trim().isEmpty()) return null;
        try {
            Uri uri = Uri.parse(value.trim());
            String scheme = uri.getScheme();
            String path = uri.getPath();
            if (("https".equalsIgnoreCase(scheme) || "http".equalsIgnoreCase(scheme))
                    && uri.getHost() != null && path != null
                    && path.matches("/delivery/driver/[A-Za-z0-9]+/?")) {
                return uri.toString();
            }
        } catch (Exception ignored) {
            // Invalid or incomplete pasted link.
        }
        return null;
    }

    private void showLinkSetup() {
        root = new LinearLayout(this);
        root.setOrientation(LinearLayout.VERTICAL);
        root.setGravity(Gravity.CENTER_VERTICAL);
        root.setPadding(dp(24), dp(28), dp(24), dp(28));
        root.setBackgroundColor(Color.rgb(244, 247, 252));

        TextView title = new TextView(this);
        title.setText("Smart Basket Delivery");
        title.setTextColor(Color.rgb(19, 39, 79));
        title.setTextSize(26);
        title.setTypeface(null, 1);
        root.addView(title);

        TextView instructions = new TextView(this);
        instructions.setText("Seller se mila apna private delivery link yahan paste karein. Link aapke assigned orders kholega.");
        instructions.setTextColor(Color.rgb(83, 99, 124));
        instructions.setTextSize(16);
        instructions.setPadding(0, dp(12), 0, dp(18));
        root.addView(instructions);

        linkInput = new EditText(this);
        linkInput.setSingleLine(true);
        linkInput.setHint("https://.../delivery/driver/...");
        linkInput.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_URI);
        linkInput.setText(getPreferences(MODE_PRIVATE).getString(LINK_KEY, ""));
        root.addView(linkInput, new LinearLayout.LayoutParams(-1, dp(56)));

        Button open = new Button(this);
        open.setText("Open my delivery app");
        open.setOnClickListener(v -> {
            String link = validDriverLink(linkInput.getText().toString());
            if (link == null) {
                Toast.makeText(this, "Seller ka complete delivery link paste karein.", Toast.LENGTH_LONG).show();
                return;
            }
            getPreferences(MODE_PRIVATE).edit().putString(LINK_KEY, link).apply();
            openDriver(link);
        });
        LinearLayout.LayoutParams buttonParams = new LinearLayout.LayoutParams(-1, dp(54));
        buttonParams.topMargin = dp(16);
        root.addView(open, buttonParams);

        setContentView(root);
    }

    private void openDriver(String link) {
        getPreferences(MODE_PRIVATE).edit().putString(LINK_KEY, link).apply();
        webView = new WebView(this);
        WebSettings settings = webView.getSettings();
        settings.setJavaScriptEnabled(true);
        settings.setDomStorageEnabled(true);
        settings.setDatabaseEnabled(true);
        settings.setGeolocationEnabled(true);
        settings.setLoadsImagesAutomatically(true);
        settings.setAllowFileAccess(false);
        settings.setAllowContentAccess(true);
        settings.setMixedContentMode(WebSettings.MIXED_CONTENT_COMPATIBILITY_MODE);

        webView.setWebViewClient(new WebViewClient() {
            @Override
            public void onReceivedError(WebView view, WebResourceRequest request, WebResourceError error) {
                if (request.isForMainFrame()) showConnectionError(link);
            }

            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                Uri uri = request.getUrl();
                String scheme = uri.getScheme();
                if ("http".equalsIgnoreCase(scheme) || "https".equalsIgnoreCase(scheme)) return false;
                try {
                    startActivity(new Intent(Intent.ACTION_VIEW, uri));
                } catch (Exception ignored) {
                    Toast.makeText(MainActivity.this, "Is link ko kholne ke liye app available nahi hai.", Toast.LENGTH_SHORT).show();
                }
                return true;
            }
        });

        webView.setWebChromeClient(new WebChromeClient() {
            @Override
            public void onGeolocationPermissionsShowPrompt(String origin, GeolocationPermissions.Callback callback) {
                if (checkSelfPermission(Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED
                        || checkSelfPermission(Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED) {
                    callback.invoke(origin, true, false);
                    return;
                }
                pendingGeoOrigin = origin;
                pendingGeoCallback = callback;
                requestPermissions(new String[]{Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_COARSE_LOCATION}, LOCATION_PERMISSION_REQUEST);
            }

            @Override
            public void onPermissionRequest(PermissionRequest request) {
                if (Build.VERSION.SDK_INT >= 21) request.grant(request.getResources());
            }
        });

        setContentView(webView);
        webView.loadUrl(link);
    }

    private void showConnectionError(String link) {
        Uri uri = Uri.parse(link);
        String host = uri.getHost() == null ? "" : uri.getHost().toLowerCase();
        boolean loopback = "localhost".equals(host) || "127.0.0.1".equals(host) || "0.0.0.0".equals(host);

        LinearLayout errorPage = new LinearLayout(this);
        errorPage.setOrientation(LinearLayout.VERTICAL);
        errorPage.setGravity(Gravity.CENTER_VERTICAL);
        errorPage.setPadding(dp(24), dp(28), dp(24), dp(28));
        errorPage.setBackgroundColor(Color.rgb(244, 247, 252));

        TextView title = new TextView(this);
        title.setText("Delivery app link nahi khul raha");
        title.setTextColor(Color.rgb(19, 39, 79));
        title.setTextSize(24);
        title.setTypeface(null, 1);
        errorPage.addView(title);

        TextView message = new TextView(this);
        message.setText(loopback
                ? "Yeh link laptop ke localhost ko point karta hai. Phone par laptop ka localhost nahi khulta. Seller se current HTTPS delivery link lein, ya same Wi-Fi par laptop ka network IP wala link use karein."
                : "Phone is server tak nahi pahunch pa raha. Internet connection check karein, aur confirm karein ki laptop ka Laravel server aur public HTTPS tunnel chalu hain.");
        message.setTextColor(Color.rgb(83, 99, 124));
        message.setTextSize(15);
        message.setPadding(0, dp(12), 0, dp(12));
        errorPage.addView(message);

        TextView currentLink = new TextView(this);
        currentLink.setText("Current link: " + link);
        currentLink.setTextColor(Color.rgb(73, 88, 112));
        currentLink.setTextSize(12);
        errorPage.addView(currentLink);

        Button retry = new Button(this);
        retry.setText("Try again");
        retry.setOnClickListener(v -> {
            setContentView(webView);
            webView.loadUrl(link);
        });
        LinearLayout.LayoutParams buttonParams = new LinearLayout.LayoutParams(-1, dp(52));
        buttonParams.topMargin = dp(14);
        errorPage.addView(retry, buttonParams);

        Button changeLink = new Button(this);
        changeLink.setText("Change delivery link");
        changeLink.setOnClickListener(v -> {
            webView = null;
            showLinkSetup();
        });
        errorPage.addView(changeLink, new LinearLayout.LayoutParams(-1, dp(52)));

        setContentView(errorPage);
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String[] permissions, int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == LOCATION_PERMISSION_REQUEST && pendingGeoCallback != null) {
            boolean granted = false;
            for (int result : grantResults) granted |= result == PackageManager.PERMISSION_GRANTED;
            pendingGeoCallback.invoke(pendingGeoOrigin, granted, false);
            pendingGeoCallback = null;
            pendingGeoOrigin = null;
        }
    }

    @Override
    public void onBackPressed() {
        if (webView != null && webView.canGoBack()) webView.goBack();
        else super.onBackPressed();
    }

    private int dp(int value) {
        return (int) (value * getResources().getDisplayMetrics().density + 0.5f);
    }
}
