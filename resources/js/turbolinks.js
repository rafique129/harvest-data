var turbolinks = require('turbolinks');
turbolinks.start();

Turbolinks.ProgressBar.prototype.installProgressElement = function () {
    const progressHolder = document.createElement('div');
    progressHolder.classList.add('progress', 'progress-sm', 'bg-transparent', 'position-absolute');
    progressHolder.setAttribute('id', 'turbo-progress')
    progressHolder.style.zIndex = 10001;
    const progress = document.createElement('div');
    progress.classList.add('progress-bar', 'progress-bar-indeterminate');
    progressHolder.appendChild(progress);
    return document.getElementById('body').before(progressHolder);
}

document.addEventListener("turbolinks:request-start", function (event) {
    const mainTint = document.getElementById('main-tint')
    if (mainTint) {
        mainTint.style.display = 'block';
    }
})
document.addEventListener("turbolinks:request-end", function (event) {
    const turboProgress = document.getElementById('turbo-progress');
    if (turboProgress) {
        turboProgress.remove();
    }

    const mainTint = document.getElementById('main-tint')
    if (mainTint) {
        mainTint.style.display = 'none';
    }
})


window.addEventListener('livewire:load', function () {
    const elements = document.getElementsByClassName('clickable-row');

    for (let index = 0; index < elements.length; index++) {
        const element = elements[index];
        element.addEventListener('click', function (event) {
            Turbolinks.visit(element.getAttribute('data-href'))
        })
    }
})
