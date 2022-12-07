# jquery.passwordStrengthForcer.js
Javascript jQuery Password Strength Forcer plugin

Include jQuery and passwordStrengthForcer plugin
```
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.passwordStrengthForcer.js"></script>
```

```
$('#newpassword').passwordStrengthForcer( {
    minlength: 8,
    maxlength: 0, //0 means no max length
    numuppercaserequired: 1,
    numdigitsrequired: 1,
    numspecialrequired: 1,
    prettystatmap:{
        minlengthgood: "Minimum Length of 8",
        maxlengthgood: "",
        uppercasegood: "1 Uppercase",
        digitsgood: "1 Digit",
        specialgood: "1 Special Char",
        good: '<i class="fa fa-check" aria-hidden="true" style="color: green"></i>',
        fail: '<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red"></i>'
    }
});
```
![Alt text](https://usercontent.irccloud-cdn.com/file/qJ5USDra/passwordStrengthForcer "Example")

On Submit
```
if ($('#newpassword').attr('data-passwordStrengthForcer_AllGood') != '1'){
        alert("New password does not match complexity requirements");
        $('#newpassword').focus();
        return false;
}
```
