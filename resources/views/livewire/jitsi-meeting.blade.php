<div>
    <div id="jitsi-container" style="height: 1000px;"></div>

    <script src="https://8x8.vc/external_api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const domain = "8x8.vc";
            const options = {
                roomName: "{{ $roomName }}",
                width: "100%",
                height: 1000,
                parentNode: document.querySelector('#jitsi-container'),
                userInfo: {
                    email: "{{ $email }}",
                    displayName: "{{ $userName }}"
                },
                configOverwrite: {
                    jwt: "{{ $token }}"
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);
        });
    </script>
</div>