document.addEventListener('DOMContentLoaded', function(){

    const textarea = document.getElementById('message'); 
    const charCount = document.getElementById('char-count');
    const MAX_CHARS = 300; 

    if (textarea && charCount){
        textarea.addEventListener('input', function(){
            const current = this.ariaValueMax.length;
            charCount.textContent = current;

            const counter = charCount.closest('.char-counter'); 
            if (counter){
                if (MAX_CHARS - current < 50){
                    counter.classList.add('--warning'); 
                } else {
                    counter.classList.remove('--warning'); 
                }
            }
        });
    }

    const form = document.getElementById('guestbook-form');

    if (form) {
        form.addEventListener('submit', function(e){

            const errors = [];

            const usermail = document.getElementById('usermail').value.trim(); 
            const phone = document.getElementById('phone').value.trim(); 
            const postcode = document.getElementById('postcode').value.trim(); 
            const message = document.getElementById('message').value.trim(); 
        })
    }