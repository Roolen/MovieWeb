var vue = new Vue({
    el: "#hello-app",
    data: {
        firstName: "",
        nickname: "",
        email: "",
        password: "",
        phone: "",
        urlRegister: "http://localhost/home/registration",

        nameWarning: "",
        nickWarning: "",
        emailWarning: "",
        passwordWarning: "",
        phoneWarning: "",

        modal: false
    },
    methods: {
        modalOpen: () => {
            vue.modal = true;
            const main = document.getElementById("main")
            main.style.filter = "blur(10px)"
            main.style.pointerEvents = "none"
            const header = document.getElementById("header")
            header.style.filter = "blur(10px)"
            header.style.pointerEvents = "none"
        },
        modalClose: () => {
            vue.modal = false;
            const main = document.getElementById("main")
            main.style.filter = "blur(0)"
            main.style.pointerEvents = "auto"
            const header = document.getElementById("header")
            header.style.filter = "blur(0)"
            header.style.pointerEvents = "auto"
        },
        registration: async () => {
            const response = await fetch(vue.urlRegister, {
                method: "POST",
                body: JSON.stringify({
                    first_name: vue.firstName,
                    nickname: vue.nickname,
                    email: vue.email,
                    password: vue.password,
                    phone_number: vue.phone
                })
            })
            const body = await response.json()

            console.log(body)

            vue.nameWarning = ""
            vue.nickWarning = ""
            vue.emailWarning = ""
            vue.passwordWarning = ""
            vue.phoneWarning = ""

            // Dublicates checks
            if (body.nickname === true) {
                vue.nickWarning = "Такой логин уже занят."
            } 

            if (body.email === true) {
                vue.emailWarning = "Такой email уже зарегистрирован."
            } 

            if (body.phone === true) {
                vue.phoneWarning = "Такой номер телефона уже зарегистрирован."
            }

            // Incorrects checks
            if (body.nameIncorrect === true) {
                vue.nameWarning = "Некорректное имя."
            }

            if (body.nickIncorrect === true) {
                vue.nickWarning = "Некорректный логин."
            }

            if (body.emailIncorrect === true) {
                vue.emailWarning = "Некорректный адрес электронной почты."
            }

            if (body.passwordIncorrect === true) {
                vue.passwordWarning = "Пароль должен быть не менее 6 и не более 24 символов."
            }

            if (body.phoneIncorrect === true) {
                vue.phoneWarning = "Некорректный номер телефона."
            }
        },
        authorize: () => {
            
        }
    }
})