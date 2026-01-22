
    document.addEventListener('alpine:init', () => {
        Alpine.data('bannerHandler', () => ({
            showThumbnail: false,
            init() {
                // Play video on load for larger screens
                if (window.innerWidth > 1024) {
                    this.playVideo();
                } else {
                    this.showThumbnail = true; // Show image on smaller screens directly
                }

                // Handle window resizing to control video and image display
                window.addEventListener('resize', () => {
                    if (window.innerWidth < 1024) {
                        this.stopVideo();
                        this.showThumbnail = true;
                    } else {
                        this.playVideo();
                        this.showThumbnail = false;
                    }
                });
            },
            playVideo() {
                if (this.$refs.videoPlayer) {
                    this.$refs.videoPlayer.play();
                }
            },
            stopVideo() {
                if (this.$refs.videoPlayer) {
                    this.$refs.videoPlayer.pause();
                }
            }
        }));
    });
