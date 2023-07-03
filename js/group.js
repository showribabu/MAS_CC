var home = document.getElementById("home");
home.addEventListener('click',()=>{
    window.location.href = "group.php";
});

var logout = document.getElementById("logout");
logout.addEventListener('click',()=>{
    window.location.href = "index.php";
}
)

var request_membership = document.getElementById("request_membership");
request_membership.addEventListener('click',()=>{
    window.location.href = "request_membership.php";
}
)

var request_list = document.getElementById("request_list");
request_list.addEventListener('click',()=>{
    window.location.href = "request_list.php";
}
)