"use strict";

//Đối tượng Validator
function Validator(options) {
  function getParent(element, selector) {
    while (element.parentElement) {
      if (element.parentElement.matches(selector)) {
        return element.parentElement;
      }
      element = element.parentElement;
    }
  }

  var selectorRules = [];

  function validate(inputElement, rule) {
    //console.log(errorMessage);
    // console.log(inputElement);
    var errorElement = getParent(
      inputElement,
      options.formGroupSelector
    ).querySelector(options.errorSelector);
    // console.log(inputElement);
    var errorMessage = rule.test(inputElement.value);

    var rules = selectorRules[rule.selector];

    //Lặp qua từng rule & kiểm tra
    // Nếu có lỗi thì ngưng việc kiểm tra
    for (var i = 0; i < rules.length; ++i) {
      switch(inputElement.type){
        case 'checkbox':
        case 'radio':
          errorMessage = rules[i](
            formElement.querySelector(rule.selector + ':checked')
          );
          break;
        default:
          errorMessage = rules[i](inputElement.value);
      }
      
      if (errorMessage) break;
    }

    if (errorMessage) {
      errorElement.innerHTML = errorMessage;
      inputElement.classList.add('is-invalid'); //Neu can su dung them class css
    } else {
      errorElement.innerHTML = "";
      inputElement.classList.remove('is-invalid');
      inputElement.classList.add('is-valid');
    }
    return !errorMessage;
  }

  var formElement = document.querySelector(options.form);
  // console.log(formElement);
  if (formElement) {
    //Khi submit form nhưng chưa đạt yêu cầu
    formElement.onsubmit = function (e) {
      e.preventDefault();

      var isFormValid = true;

      // Lặp qua từng rule và validate
      options.rules.forEach(function (rule) {
        var inputElement = formElement.querySelector(rule.selector);
        //  console.log(inputElement);
        var isValid = validate(inputElement, rule);
        if (!isValid) {
          isFormValid = false;
        }
      });

      if (isFormValid) {
        //Trường hợp submit với javascript
        if (typeof options.onsubmit === 'function') {
          var enableInputs = formElement.querySelectorAll('[name]');
          var formValues = Array.from(enableInputs).reduce(function (values,input) {
            
           switch(input.type){
             case 'radio':
               values[input.name] = formElement.querySelector('input[name="' + input.name + '"]:checked').value;
               break;
             case 'checkbox':
               if(!input.matches(':checked')){
                 values[input.name] = [];
                 return values;
               } 
               if(!Array.isArray(values[input.name])){
                 values[input.name] = [];
               }
               values[input.name].push(input.value);
               break;
               case 'file': 
                    values[input.name] = input.files;
                break;
              default:
                values[input.name] = input.value;
           }
           
            return values;
          },{});
           options.onsubmit(formValues);
        } else { //Submit với hành động mặc định của file
            formElement.submit();
        }
      }
    };
    //Lắng nghe mỗi rule và xử lý
    options.rules.forEach(function (rule) {
      //Lưu lại các Rules cho mỗi Input
      if (Array.isArray(selectorRules[rule.selector])) {
        selectorRules[rule.selector].push(rule.test);
      } else {
        selectorRules[rule.selector] = [rule.test];
      }

      //console.log(rule.selector);
      var inputElements = formElement.querySelectorAll(rule.selector);
      Array.from(inputElements).forEach(function (inputElement){
        inputElement.onblur = function () {
          //value: inputElement.value
          //test func: rule.test
          //console.log('blur ' + rule.selector);
          //console.log(inputElement.value);
          //console.log(rule);
          validate(inputElement, rule);
        };

        inputElement.oninput = function () {
          var errorElement = getParent(
            inputElement,
            options.formGroupSelector
          ).querySelector(options.errorSelector);
          //console.log(inputElement.value);
          errorElement.innerHTML = "";
          inputElement.classList.remove('is-invalid');
          inputElement.classList.remove('is-valid');
        };
      });
      //console.log(inputElement);

    });
    //console.log(selectorRules);
  }
}

//Định nghĩa Rules
//Nguyên tắc của các rules:
//1. Khi có lỗi => Trả ra mess lỗi
//2. Khi hợp lệ => Không trả ra gì cả (undefined)
Validator.isRequired = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      return value ? undefined: message || '<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng không để trống trường này';
    },
  };
};

Validator.isPassword = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/i;
      return regex.test(value) ? undefined : message || '<i class="fas fa-exclamation-triangle warn_icon"></i>Mật Khẩu phải có tối thiểu tám ký tự, ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số và một kí tự đặc biệt!';
    },
  };
};

Validator.isEmail = function (selector, message) {
  return {
    selector: selector,
    test: function (value) {
      var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      return regex.test(value) ? undefined : message || '<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng nhập đúng định dạng Email';
    },
  };
};

Validator.isConfirmed = function (selector, getConfirmValue, message) {
  return {
    selector: selector,
    test: function (value) {
      return value === getConfirmValue() ? undefined: message || 'Giá trị nhập vào không chính xác';
    },
  };
};

