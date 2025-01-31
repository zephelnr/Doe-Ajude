function DemonstrarInteresse() {
    const frmInteresse = document.getElementById("frmInteresse");
    
    let formData = new FormData(frmInteresse);

    console.log(formData);
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status == 200 && xhr.readyState == 4) {
            console.log(xhr.responseText);
        }
        else {
            console.log("XMLHttpRequest Error");
        }
    }

    xhr.open("POST", "demonstrarInteresse.php");
    xhr.send(formData);
}