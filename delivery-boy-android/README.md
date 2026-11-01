# Smart Basket Delivery Android app

This is the editable Android Studio source for a small WebView APK wrapper around the existing Laravel delivery-boy app. The driver interface, assigned orders, seller assignments, customer information, and status updates remain served by this project; the APK does not contain or copy the Laravel database.

## Connect a driver

The APK accepts the private driver URL copied from the Seller delivery-boys page. It can be pasted on first launch, or Android can open the APK directly when the driver taps a supported `https://.../delivery/driver/<token>` link. The URL must point to a server reachable from the phone. A loopback URL such as `127.0.0.1` only works on the same device. For private access from different networks, install Tailscale on the server and phone and sign both into the same tailnet; launch the Laravel project with the root `start-private-network.bat` script and copy a fresh driver link.

## Build the APK

1. Install Android Studio with Android SDK Platform 37 and JDK 17 or newer.
2. Open this `delivery-boy-android` folder in Android Studio and let Gradle sync.
3. Choose **Build > Build Bundle(s) / APK(s) > Build APK(s)**.
4. Android Studio writes the debug APK under `app/build/outputs/apk/debug/`.

The source is editable in VS Code. Laravel/Blade changes continue to come from the server and appear after the driver app reloads. Native Android changes require rebuilding and reinstalling the APK. All driver phones need Tailscale connected while using a private tailnet URL.

## Notes

- The app requests location permission so the existing driver page can share GPS.
- Use an HTTPS server for cross-network access and browser location features.
- Seller, customer, and admin panels stay in the same Laravel website; this APK opens the driver's private portal only.
