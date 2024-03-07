


var laydiv = document.getElementById('div-tinnhan')
var laya = laydiv.getElementsByClassName('dropdown-item d-flex align-items-center')
var count = laya.length
var stn = document.getElementById('so-tinnhan')
stn.innerHTML = count



// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('ea6012be0da9b8704099', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('my');
channel.bind('my', function (data) {

    // Tạo một phần tử div để chứa thông tin
    var blockElement = document.createElement("a");
    blockElement.classList.add("dropdown-item", "d-flex", "align-items-center");
    blockElement.href = "#";

    // Tạo phần tử div chứa icon
    var iconContainer = document.createElement("div");
    iconContainer.classList.add("mr-3");

    var iconCircle = document.createElement("div");
    iconCircle.classList.add("icon-circle", "bg-success");

    var icon = document.createElement("i");
    icon.classList.add("fas", "fa-donate", "text-white");

    iconCircle.appendChild(icon);
    iconContainer.appendChild(iconCircle);

    // Tạo phần tử div chứa thông tin ngày và số tiền
    var infoContainer = document.createElement("div");

    var dateElement = document.createElement("div");
    dateElement.classList.add("small", "text-gray-500");
    dateElement.textContent = "December 12, 2019";

    var amountElement = document.createTextNode(data);

    infoContainer.appendChild(dateElement);
    infoContainer.appendChild(amountElement);

    // Gắn các phần tử con vào blockElement
    blockElement.appendChild(iconContainer);
    blockElement.appendChild(infoContainer);

    // Gắn blockElement vào container đã có trên trang HTML
    // Lấy phần tử cha
    var container = document.getElementById("div-tinnhan");

    // Lấy phần tử đầu tiên trong container
    var firstChild = container.querySelector('#dau');
    // Chèn khối mới vào trước phần tử đầu tiên
    container.insertBefore(blockElement, firstChild.nextSibling);

    var laydiv = document.getElementById('div-tinnhan')
    var laya = laydiv.getElementsByClassName('dropdown-item d-flex align-items-center')
    var count = laya.length
    var stn = document.getElementById('so-tinnhan')
    stn.innerHTML = count


})