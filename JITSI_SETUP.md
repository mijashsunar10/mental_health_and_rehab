# Jitsi Video Call Setup Guide

## Option 1: Free Jitsi Meet (No Authentication Required)

### Quick Setup for Testing

1. **Update JitsiMeeting.php**:

```php
<?php
namespace App\Livewire;

use Livewire\Component;

class JitsiMeeting extends Component
{
    public $roomName;
    public $userName;
    public $email;

    public function mount($room = 'TestRoom')
    {
        // Use free Jitsi Meet server
        $this->roomName = $room . '-' . uniqid(); // Add unique ID to room name
        $this->userName = auth()->user() ? auth()->user()->name : 'Guest';
        $this->email = auth()->user() ? auth()->user()->email : 'guest@example.com';
    }

    public function render()
    {
        return view('livewire.jitsi-meeting-free')
            ->layout('layouts.empty');
    }
}
```

2. **Create jitsi-meeting-free.blade.php**:

```blade
<div>
    <div id="jitsi-container" style="height: 100vh;"></div>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const domain = "meet.jit.si";
            const options = {
                roomName: "{{ $roomName }}",
                width: "100%",
                height: "100%",
                parentNode: document.querySelector('#jitsi-container'),
                userInfo: {
                    email: "{{ $email }}",
                    displayName: "{{ $userName }}"
                },
                configOverwrite: {
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    enableWelcomePage: false
                },
                interfaceConfigOverwrite: {
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone'
                    ]
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);

            // Optional: Listen to events
            api.addEventListener('videoConferenceJoined', () => {
                console.log('User joined the conference');
            });

            api.addEventListener('videoConferenceLeft', () => {
                console.log('User left the conference');
                window.location.href = '/dashboard'; // Redirect after leaving
            });
        });
    </script>
</div>
```

---

## Option 2: Jitsi as a Service (JaaS) - Production Setup

### Step 1: Create JaaS Account

1. Visit https://jaas.8x8.vc/
2. Sign up for an account
3. Create a new application
4. Go to "Developers" > "API Keys"

### Step 2: Generate API Credentials

You'll receive:
- **APP_ID**: e.g., `vpaas-magic-cookie-abc123xyz`
- **TENANT_ID**: Your tenant name (e.g., `vpaas-magic-cookie-abc123xyz`)
- **API Key ID (KID)**: e.g., `vpaas-magic-cookie-abc123xyz/a1b2c3`
- **Private Key**: RSA private key

### Step 3: Download Private Key

When you generate an API key, download the private key file. It will look like:

```
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC7VJTUt9Us8cKj
MzBjjHBSUfts0CkpSeEHQvZ0qGDKH2vzD6M9vE4P4WnMGDYJ5pqfL3yGr0ydL1Fb
...
(many more lines)
...
-----END PRIVATE KEY-----
```

### Step 4: Configure Environment Variables

Open your `.env` file and add:

```env
JAAS_APP_ID=vpaas-magic-cookie-YOUR_APP_ID
JAAS_TENANT_ID=vpaas-magic-cookie-YOUR_TENANT_ID
JAAS_KID=vpaas-magic-cookie-YOUR_TENANT_ID/YOUR_KEY_ID
JAAS_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC7VJTUt9Us8cKj
(paste your entire private key here)
-----END PRIVATE KEY-----"
```

**CRITICAL:**
- Keep quotes around `JAAS_PRIVATE_KEY`
- Keep the BEGIN/END markers
- Preserve newlines in the private key

### Step 5: Alternative - Store Private Key in File

For better security, store the private key in a file:

1. Create `storage/keys/jaas-private-key.pem`
2. Paste your private key there
3. Update `.env`:

```env
JAAS_PRIVATE_KEY_PATH=/path/to/storage/keys/jaas-private-key.pem
```

4. Update `JaaSService.php`:

```php
$privateKeyPath = env('JAAS_PRIVATE_KEY_PATH');
if ($privateKeyPath && file_exists($privateKeyPath)) {
    $privateKey = file_get_contents($privateKeyPath);
} else {
    $privateKey = env('JAAS_PRIVATE_KEY');
    $privateKey = str_replace('\\n', "\n", $privateKey);
}
```

---

## Step 6: Clear Configuration Cache

After updating `.env`:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## Troubleshooting

### Error: "OpenSSL unable to validate key"

**Cause:** Private key is not properly formatted

**Solution:**
1. Ensure private key has proper newlines (not literal `\n`)
2. Check that BEGIN/END markers are present
3. Verify no extra spaces or characters
4. Try storing key in a file instead of .env

### Error: "JaaS configuration is incomplete"

**Cause:** Missing environment variables

**Solution:**
1. Check all four variables are set: `JAAS_APP_ID`, `JAAS_TENANT_ID`, `JAAS_KID`, `JAAS_PRIVATE_KEY`
2. Run `php artisan config:clear`
3. Restart your web server

### Error: Token validation failed

**Cause:** Incorrect APP_ID or KID

**Solution:**
1. Double-check credentials from JaaS dashboard
2. Ensure APP_ID matches your Jitsi application
3. Verify KID format includes tenant ID prefix

---

## Testing

1. Navigate to your video call route (e.g., `/jitsi-meeting`)
2. You should see the Jitsi interface load
3. Grant camera/microphone permissions
4. Invite another user to test

---

## For Production

1. Use JaaS (Option 2) for better control and branding
2. Store private key in a file, not .env
3. Set proper CORS headers
4. Implement room access controls
5. Add authentication checks before joining

---

## Cost

- **Free Jitsi Meet**: Free, no limits, but shared infrastructure
- **JaaS**: Free tier available, then $0.05 per participant minute

---

## Need Help?

- JaaS Documentation: https://developer.8x8.com/jaas/docs
- Jitsi Community: https://community.jitsi.org/
