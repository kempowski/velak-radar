export default class AudioPlayer {
    constructor(selector = '.audioPlayer', audio = []) {
        this.playerElem = document.querySelector(selector);
        this.audio = audio;
        this.currentAudio = null;
        this.createPlayerElements();
        this.audioContext = null;
    }

    createPlayerElements() {
        this.audioElem = document.createElement('audio');
        const playListElem = document.createElement('div');
        playListElem.classList.add('playlist');
        const playElem = document.createElement('button');
        playElem.classList.add('play');
        playElem.innerHTML = '<i class="fa fa-play"></i>';
        // this.visualiserElem = document.createElement('canvas');
        this.playerElem.appendChild(this.audioElem);
        this.playerElem.appendChild(playListElem);
        // this.playerElem.appendChild(this.visualiserElem);

        this.createPlayListElements(playListElem);
    }

    createPlayListElements(playListElem) {
        this.audio.forEach(audio => {
            const audioItem = document.createElement('a');
            audioItem.href = audio.url;
            audioItem.innerHTML = `<i class="fa fa-play"></i>${audio.name}`;
            this.setEventListener(audioItem);
            playListElem.appendChild(audioItem);
        });
    }

    setEventListener(audioItem) {
        audioItem.addEventListener('click', (e) => {
            e.preventDefault();
           
            const isCurrentAudio = audioItem.getAttribute('href') == (this.currentAudio && this.currentAudio.getAttribute('href'));

            if (isCurrentAudio && !this.audioElem.paused) {
                this.setPlayIcon(this.currentAudio);
                this.audioElem.pause();
            } else if (isCurrentAudio && this.audioElem.paused) {
                this.setPauseIcon(this.currentAudio);
                this.audioElem.play();

            } else {
                if (this.currentAudio) {
                    this.setPlayIcon(this.currentAudio);
                }
                this.currentAudio = audioItem;
                this.setPauseIcon(this.currentAudio);
                this.audioElem.src = this.currentAudio.getAttribute('href');
                this.audioElem.play();
            }

        })
    }

    setPauseIcon(elem) {
        const icon = elem.querySelector('i');
        icon.classList.add('fa-pause');
        icon.classList.remove('fa-play');
    }

    setPlayIcon(elem) {
        const icon = elem.querySelector('i');
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');
    };
}