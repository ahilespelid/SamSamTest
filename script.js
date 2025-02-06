//document.addEventListener("DOMContentLoaded", function(){
    const contactTable  = document.getElementById('contactTable');
    const contactForm   = document.getElementById('contactForm');
    const addEditForm   = document.getElementById('addEditForm');
    const saveButton    = document.getElementById('saveButton');
    let currentRow      = null;
    
    ///*/ahilespelid Функция для получения всех контактов /*/// 
    function getContacts(){
        fetch('api.php', {method: 'GET', headers: {'Accept': 'application/json'}}).then(response => response.json())
        .then(data => {
            while (contactTable.rows.length > 1) {contactTable.deleteRow(1);}
            
            data.forEach(contact => {
                const row     = contactTable.insertRow(-1);
                row.id        = contact.id;
                row.innerHTML = `
                    <td>${contact.id}</td>
                    <td>${contact.name}</td>
                    <td>${contact.phone}</td>
                    <td>${contact.email}</td>
                    <td>
                        <button onclick="editContact(${contact.id})" data-act="editContact" data-id="${contact.id}">Изменить</button>
                        <button onclick="deleteContact(${contact.id})" data-act="deleteContact" data-id="${contact.id}">Удалить</button>
                    </td>`;
            });
        }).catch(error => console.error('Ошибка:', error));
    }
    ///*/ahilespelid Функция для добавления нового контакта /*///
    function addContact(event){event.preventDefault();
        const name  = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim(); 

        if(validateFields(name, phone, email)){
            fetch('api.php', {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ name, phone, email })}).then(response => response.json())
            .then(data => {
                if(data.message === 'Контакт добавлен'){
                    clearForm(); closeForm(); getContacts();
                }else{alert('Произошла ошибка при добавлении контакта.');}
            }).catch(error => console.error('Ошибка:', error));
    }}
    ///*/ahilespelid Функция для редактирования существующего контакта /*///
    function editContact(id){
        currentRow                             = document.getElementById(id.toString());
        const cells                            = currentRow.cells;
        document.getElementById('name').value  = cells[1].innerText;
        document.getElementById('phone').value = cells[2].innerText;
        document.getElementById('email').value = cells[3].innerText;
        openForm();
    }

    ///*/ahilespelid Функция для сохранения изменений в контакте /*///
    function updateContact(event){event.preventDefault();
        const id    = parseInt(currentRow.id);
        const name  = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();

        if(validateFields(name, phone, email)){
            fetch('api.php', {method: 'PUT', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ id, name, phone, email })}).then(response => response.json())
            .then(data => {
                if(data.message === 'Контакт обновлён'){
                    clearForm(); closeForm(); getContacts();
                }else{alert('Произошла ошибка при обновлении контакта.');}}).catch(error => console.error('Ошибка:', error));
    }}

    ///*/ahilespelid Функция для удаления контакта /*///
    function deleteContact(id){
        if(confirm('Вы уверены, что хотите удалить этот контакт?')){
            fetch('api.php', {method: 'DELETE', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ id })}).then(response => response.json())
            .then(data => {
                if(data.message === 'Контакт удалён'){
                    getContacts(); 
                }else{alert('Произошла ошибка при удалении контакта.');}}).catch(error => console.error('Ошибка:', error));
        }
    }

    ///*/ahilespelid Функция для открытия формы добавления/редактирования
    function openForm(){
        contactForm.style.display = 'block';
        saveButton.onclick        = updateContact;
    }

    ///*/ahilespelid Функция для закрытия формы /*///
    function closeForm(){
        contactForm.style.display = 'none';
        saveButton.onclick        = addContact;
    }

    ///*/ahilespelid Функция для очистки формы /*///
    function clearForm() {
        document.getElementById('name').value  = '';
        document.getElementById('phone').value = '';
        document.getElementById('email').value = '';
    }

    ///*/ahilespelid Функция для проверки введенных данных /*///
    function validateFields(name, phone, email){
        let isValid = true;
        if (!name || !phone || !email){
            alert('Все поля обязательны для заполнения!');
            isValid = false;
        }
    return isValid;}

    ///*/ahilespelid Инициализация таблицы контактов при загрузке страницы /*///
    getContacts();

    ///*/ahilespelid Добавление обработчика события на кнопку "Сохранить" /*///
    saveButton.onclick = addContact;
    
    ///*/ahilespelid Тестирование js /*///
    console.log(contactTable);
    console.log(contactForm);
    console.log(addEditForm);
    console.log(saveButton);
    console.log(currentRow);
    
    var allfunctions=[];
    for(var i in window){
        if((typeof window[i]).toString()=="function"){
            allfunctions.push(window[i].name);
    }}
    console.log(allfunctions);
//});