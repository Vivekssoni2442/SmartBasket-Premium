param(
    [Parameter(Mandatory = $true)]
    [string] $Tailscale
)

$ErrorActionPreference = 'Stop'
try {
    $status = & $Tailscale status --json | ConvertFrom-Json
    $dnsName = ([string] $status.Self.DNSName).TrimEnd('.')
    if ($dnsName -notmatch '^[a-z0-9-]+\.[a-z0-9-]+\.ts\.net$') {
        exit 1
    }
    Write-Output "https://$dnsName"
} catch {
    exit 1
}
