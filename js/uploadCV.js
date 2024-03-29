let dropText = document.getElementsByClassName("drop_text");

let uploadFile;
function dropHandler(ev) {
    console.log("File(s) dropped");

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();

    if (ev.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        [...ev.dataTransfer.items].forEach((item, i) => {
            // If dropped items aren't files, reject them
            if (item.kind === "file") {
                const file = item.getAsFile();
                uploadFile = file;
                dropText[0].textContent = file.name;
                dropText[1].textContent = "";
            }
        });
    } else {
        // Use DataTransfer interface to access the file(s)
        [...ev.dataTransfer.files].forEach((file, i) => {
            uploadFile = file;
            dropText[0].textContent = file.name;
            dropText[1].textContent = "";
        });
    }
}

function dragOverHandler(ev) {
    ev.preventDefault();
}

function clickHandler(ev) {
    ev.preventDefault();

    var input = document.createElement('input');
    input.addEventListener("change", handleFiles, false);
    input.type = 'file';
    input.click();
}

function handleFiles() {
    dropText[0].textContent = this.files[0].name;
    dropText[1].textContent = "";
    uploadFile = this.files[0];
}

sendBtn = document.getElementById("btn-send-cv");

let vacancyId;

sendBtn.onclick = async function () {
    if (uploadFile == null) {
        alert("Выберите файл перед оправкой!");
        return;
    }
    // object = { "id": id, "name": uploadFile.name, "file": fileBase64 };

    let formData = new FormData();
    formData.append('vacancy_id', vacancyId);
    formData.append('file', uploadFile);

    var req = jQuery.ajax({
        url: '/request.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false
    });


    console.log(req);
    req.then(function (response) {
        alert("Ваше резюме успешно отправлено. Спасибо!");
        modalVacancy.style.display = "none";
        console.log(response);
    }, function (xhr) {
        // alert("При отправке резюме произошла ошибка: " + JSON.parse(xhr)['error']);
        alert("При отправке резюме произошла ошибка: " + xhr.responseText);
        console.log(xhr);
        console.log(xhr.responseText);
    })
}


if (btnsVacancy != null) {
    for (let i = 0; i < btnsVacancy.length; i++) {
        btnsVacancy[i].onclick = function () {
            vacancyId = btnsVacancy[i].getAttribute("vacancy-id");
            modalVacancy.style.display = "block";
        }
    }
}