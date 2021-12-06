jQuery(document).ready(function($) {
//progress bar
const readingProgress = (contentArea, progressBar) => {
    const content = document.querySelector(contentArea);
    const progress = document.querySelector(progressBar);
    const frameListening = () => {
        const contentBox = content.getBoundingClientRect();
        const midPoint = window.innerHeight / 2;
        const minsRemaining = Math.round(progress.max - progress.value);
        if (contentBox.top > midPoint) {
            progress.value = 0;
        }
        if (contentBox.top < midPoint) {
            progress.value = progress.max;
        }
        if (contentBox.top <= midPoint && contentBox.bottom >= midPoint) {
            progress.value =
                (progress.max * Math.abs(contentBox.top - midPoint)) /
                contentBox.height;
        }
        window.requestAnimationFrame(frameListening);
    };
    window.requestAnimationFrame(frameListening);
  };
  readingProgress(".article-post", ".reading-progress-bar");
  });