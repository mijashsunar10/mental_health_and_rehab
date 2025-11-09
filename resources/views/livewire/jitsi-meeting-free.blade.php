<div>
    <div id="jitsi-container" style="height: 100vh; width: 100%;"></div>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const domain = "meet.jit.si"; // Free Jitsi server
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
                    enableWelcomePage: false,
                    prejoinPageEnabled: false,
                    disableDeepLinking: true
                },
                interfaceConfigOverwrite: {
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats',
                        'tileview', 'download', 'help'
                    ],
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false
                }
            };

            const api = new JitsiMeetExternalAPI(domain, options);

            // Event listeners
            api.addEventListener('videoConferenceJoined', (data) => {
                console.log('User joined the conference:', data);
            });

            api.addEventListener('videoConferenceLeft', () => {
                console.log('User left the conference');
                // Optionally redirect to dashboard
                // window.location.href = '/dashboard';
            });

            api.addEventListener('participantJoined', (data) => {
                console.log('Participant joined:', data);
            });

            api.addEventListener('participantLeft', (data) => {
                console.log('Participant left:', data);
            });
        });
    </script>

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #jitsi-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
    </style>
</div>
