param(
    [Parameter(Mandatory = $true)]
    [string] $Cloudflared
)

# cloudflared writes informational logs to stderr; PowerShell must not treat
# those normal native-process messages as a terminating script error.
$ErrorActionPreference = 'Continue'
$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$urlFile = Join-Path $projectRoot 'storage\app\driver-public-url.txt'

if (-not (Test-Path -LiteralPath $Cloudflared -PathType Leaf)) {
    Write-Host "Cloudflare Tunnel executable was not found: $Cloudflared" -ForegroundColor Red
    exit 1
}

New-Item -ItemType Directory -Force -Path (Split-Path -Parent $urlFile) | Out-Null
Remove-Item -LiteralPath $urlFile -Force -ErrorAction SilentlyContinue
Write-Host 'Starting temporary HTTPS tunnel to http://127.0.0.1:8000 ...' -ForegroundColor Cyan
Write-Host 'Keep this window open. The current public URL will appear below.'

& $Cloudflared tunnel --protocol http2 --url 'http://127.0.0.1:8000' 2>&1 | ForEach-Object {
    $line = [string] $_
    Write-Host $line

    if ($line -match 'https://[a-z0-9-]+\.trycloudflare\.com' -and $Matches[0] -ne 'https://api.trycloudflare.com') {
        $publicUrl = $Matches[0].TrimEnd('.')
        Set-Content -LiteralPath $urlFile -Value $publicUrl -NoNewline -Encoding ascii
        Write-Host "Smart Basket public link: $publicUrl" -ForegroundColor Green
        Write-Host 'Seller delivery-boy links will use this URL while the tunnel is active.' -ForegroundColor Green
    }
}

if (Test-Path -LiteralPath $urlFile) {
    Remove-Item -LiteralPath $urlFile -Force -ErrorAction SilentlyContinue
    Write-Host 'The tunnel stopped. Start this launcher again to get a new public URL.' -ForegroundColor Yellow
} else {
    Write-Host 'Cloudflare did not issue a public URL. Check this computer’s internet/VPN/firewall and try again.' -ForegroundColor Red
}
