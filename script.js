document.addEventListener('DOMContentLoaded', function() {
    const signupTab = document.getElementById('signup-tab');
    const signinTab = document.getElementById('signin-tab');
    const signupForm = document.getElementById('signup-form');
    const signinForm = document.getElementById('signin-form');

    signupTab.addEventListener('click', function() {
        signupTab.classList.add('active');
        signinTab.classList.remove('active');
        signupForm.classList.add('active');
        signinForm.classList.remove('active');
    });

    signinTab.addEventListener('click', function() {
        signinTab.classList.add('active');
        signupTab.classList.remove('active');
        signinForm.classList.add('active');
        signupForm.classList.remove('active');
    });
});
