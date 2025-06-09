//dodavat js-ove za stranice

$(document).on('click', 'a[href="#profile"]', function(e) {
    e.preventDefault();
    const token = localStorage.getItem("user_token");
    if (!token) {
        window.location.replace("login.html");
        return;
    }
    const user = Utils.parseJwt(token).user;
    if (user && (user.role_id === 1 || user.role === 'admin' || user.role === 'Admin')) {
        window.location.hash = "#adminpanel";
    } else {
        window.location.hash = "#profile";
    }
});