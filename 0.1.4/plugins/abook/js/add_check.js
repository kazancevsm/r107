var req = Create(), query, path;
function ge(id)
{
    return document.getElementById(id);
}

function Create(){ 
if(navigator.appName == "Microsoft Internet Explorer"){
req = new ActiveXObject("Microsoft.XMLHTTP");
}else{
req = new XMLHttpRequest();
}
return req;
}
function Request(){
req.open('post', path , true );
req.onreadystatechange = Refresh;
req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
req.send(query);
}
function Refresh(){
   var subm = '';
     	if( req.readyState == 4 )
	subm = req.responseText;
    ge('cod').innerHTML = subm;
  if (subm == '<img src="./theme/check_no.png"/>') {
      document.getElementById('submit').disabled = true;
    } else {
      document.getElementById('submit').disabled = false;
    }
}

function checkname(){
	p_gnl_name=document.form_add.gnl_name.value.toString();
	if (p_gnl_name==""){
	document.getElementById('check_name').innerHTML ='<img src="./theme/check_no.png"/>';
	return false;
	} else {
	document.getElementById('check_name').innerHTML ='<img src="./theme/check_yes.png"/>';
	return true;
	}
}
function checkcity(){
p_cat_name=document.form_add.gnl_city.value;
	if (p_cat_name== 0){
	document.getElementById('check_city').innerHTML ='<img src="./theme/check_no.png"/>';
	return false;
	}else{
	document.getElementById('check_city').innerHTML ='<img src="./theme/check_yes.png"/>';
	return true;
	}
}
function checkaddress(){
p_gnl_detail=document.form_add.gnl_address.value;
	if (p_gnl_detail.length < 10 || p_gnl_detail.length > 500) {
	document.getElementById('check_address').innerHTML ='<img src="./theme/check_no.png"/>';
	return false;
	}else{
	document.getElementById('check_address').innerHTML ='<img src="./theme/check_yes.png"/>';
	return true;
	}
}
function checkconname() {
p_gnl_price=document.form_add.gnl_conname.value;
	if (p_gnl_price=="") {
	document.getElementById('check_conname').innerHTML ='<img src="./theme/check_no.png"/>';
	return false;
	}else{
	document.getElementById('check_conname').innerHTML ='<img src="./theme/check_yes.png"/>';
	return true;
	}
}
function checkconphone() {
p_gnl_user=document.form_add.gnl_conphone.value;
	if (p_gnl_user=="" || p_gnl_user.length < 3) {
	document.getElementById('check_conphone').innerHTML ='<img src="./theme/check_no.png"/>';
	return false;
	}
	else { 
	document.getElementById('check_conphone').innerHTML ='<img src="./theme/check_yes.png"/>';
	}
}
function checkdevision(){
p_gnl_city=document.form_add.gnl_devision.value;
	if (p_gnl_city==""){
	document.getElementById('check_devision').innerHTML ='<img src="./theme/check_no.png"/><br> Введите не менее 10 знаков и не более 500';
	return false;
	} else {
	document.getElementById('check_devision').innerHTML ='<img src="./theme/check_yes.png"/>';
	return true;
	}
}
// =======Check add notis from form_add=====
function f_submit_add(){
	p_conf_check_ans=document.form_add.conf_check_ans.value;
	p_gnl_name=document.form_add.gnl_name.value;
	p_cat_name=document.form_add.cat_sub_id.value;
	p_gnl_detail=document.form_add.gnl_detail.value;
	p_gnl_price=document.form_add.gnl_price.value;
	p_gnl_user=document.form_add.gnl_user.value;
	p_gnl_city=document.form_add.gnl_city.value;
	p_gnl_phone=document.form_add.gnl_phone.value;
	p_gnl_check=document.form_add.gnl_check.value;
	if (p_gnl_name == ""){	gnl_name_emp = "Заголовок объявления;";}	else {gnl_name_emp = "";}
	if (p_cat_name == ""){	gnl_cat_emp = "Подкатегория;";}			else {gnl_cat_emp = "";}
	if (p_gnl_detail == ""){gnl_detail_emp = "Текст объявления;";}		else {gnl_detail_emp = "";}
	if (p_gnl_price == ""){	gnl_price_emp = "Цена;";}			else {gnl_price_emp = "";}
	if (p_gnl_user == ""){	gnl_user_emp = "Ваше имя;";}			else {gnl_user_emp = "";}
	if (p_gnl_city == ""){	gnl_city_emp = "Населенный пункт;";}		else {gnl_city_emp = "";}
	if (p_gnl_phone == ""){	gnl_phone_emp = "Телефон;";}			else {gnl_phone_emp = "";}
	if (p_gnl_check == "" || p_gnl_check != p_conf_check_ans){	gnl_check_emp = "Контрольный вопрос;";}		else {gnl_check_emp = "";}
	message = gnl_name_emp+gnl_cat_emp+gnl_detail_emp+gnl_price_emp+gnl_user_emp+gnl_city_emp+gnl_phone_emp+gnl_check_emp;
if (p_gnl_name=="" || p_cat_name=="" || p_gnl_detail=="" || p_gnl_price=="" || p_gnl_user=="" || p_gnl_city=="" || p_gnl_phone=="" || p_gnl_check=="" || p_gnl_check != p_conf_check_ans){
	alert ("Ваше объявление не добавлено! Проверьте пожалуйста поля:" + message);
	}
else {
	alert ("Спасибо, что Вы воспользовались нашей доской объявлений! Ваше объявление добавлено!");
}
}
function confirmDeleteNotice(){
	if (confirm("Вы действительно хотите удалить объявление?")) {
		return true;
	} else {
	        return false;
	}
}