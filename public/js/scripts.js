var xhr = new XMLHttpRequest ()
var form = document.getElementById ('insurance_form')
var ajaxIndicator = document.getElementById('ajax-indicator')
var btn = document.getElementById('calculate_insurance')
var table = document.getElementById('installment_table')

function ajaxStarted() {
    var elements = document.getElementsByClassName('invalid-feedback');
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
    ajaxIndicator.classList.remove('d-none')
    btn.innerText='please wait...'
    btn.disabled=true
}

function ajaxStopped() {
    ajaxIndicator.classList.add('d-none')
    btn.innerText='Calculate'
    btn.disabled=false
}

function errorDiv (txt) {
    var x = document.createElement("div")
    var t = document.createTextNode(txt)
    x.appendChild(t)
    x.classList.add('invalid-feedback')
    return x
}

xhr.onload = function () {

    if (xhr.status >= 200 && xhr.status < 300) {
        var obj = JSON.parse(xhr.responseText);
        if (obj.code != 0) {
            for (var k in obj.errors){
                if (obj.errors.hasOwnProperty(k)) {
                    document.getElementById(k).classList.add('is-invalid')
                    document.getElementById(k).after(errorDiv(obj.errors[k]))
                }
            }
        } else {
            table.innerHTML = obj.table
            table.scrollIntoView({
                behavior: 'smooth'
            })
        }
    } else {
        // This will run when it's not
        console.log ('The request failed!');
    }

    ajaxStopped()
};


form.addEventListener ('submit', function (e) {
    e.preventDefault()
    ajaxStarted();
    var form = e.target
    var data = new FormData(form)

    Array.prototype.forEach.call(form.elements, function(el, index, array){
        el.classList.remove('is-invalid')
    });

    xhr.open (form.method, form.action);
    xhr.send (data);
});

document.querySelector("input.numeric-only").addEventListener("keypress", function (e) {
    if ((e.which < 48 || e.which > 57) && e.which != 46)
    {
        e.preventDefault();
    }
});