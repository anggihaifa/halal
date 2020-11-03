        var myInput = document.getElementById("password");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");


        document.getElementById("lblx").style.display = "none";
        document.getElementById("valx").style.display = "none";
        document.getElementById("pwdvalidation").style.display = "none";

        myInput.onfocus = function() {
            document.getElementById("lblx").style.display = "block";
            document.getElementById("valx").style.display = "block";
            document.getElementById("pwdvalidation").style.display = "block";
        }    

        myInput.onblur = function() {
            document.getElementById("lblx").style.display = "none";
            document.getElementById("valx").style.display = "none";
            document.getElementById("pwdvalidation").style.display = "none";
        }

        myInput.onkeyup = function(){
            //validate lowercase
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)){
                letter.classList.remove("ion-ios-close-circle-outline");
                letter.classList.add("ion-ios-checkmark-circle-outline");
                $('#letter').css('color', '#5acc5a');
            }else{
                letter.classList.remove("ion-ios-checkmark-circle-outline");
                letter.classList.add("ion-ios-close-circle-outline");
                $('#letter').css('color', 'red');
            }    

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {  
                capital.classList.remove("ion-ios-close-circle-outline");
                capital.classList.add("ion-ios-checkmark-circle-outline");
                $('#capital').css('color', '#5acc5a');
            } else {
                capital.classList.remove("ion-ios-checkmark-circle-outline");
                capital.classList.add("ion-ios-close-circle-outline");
                $('#capital').css('color', 'red');
            }

            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {  
                number.classList.remove("ion-ios-close-circle-outline");
                number.classList.add("ion-ios-checkmark-circle-outline");
                $('#number').css('color', '#5acc5a');
            } else {
                number.classList.remove("ion-ios-checkmark-circle-outline");
                number.classList.add("ion-ios-close-circle-outline");
                $('#number').css('color', 'red');
            }
            
            // Validate length
            if(myInput.value.length >= 8) {
                length.classList.remove("ion-ios-close-circle-outline");
                length.classList.add("ion-ios-checkmark-circle-outline");
                $('#length').css('color', '#5acc5a');
            } else {
                length.classList.remove("ion-ios-checkmark-circle-outline");
                length.classList.add("ion-ios-close-circle-outline");
                $('#length').css('color', 'red');
            }

        }