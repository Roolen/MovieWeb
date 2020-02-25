const settings = new Vue({
    el: '#settings-app',
    data: {
        settings: [],
        acceptMessage: "",
        messageStyle: "",
        urlGetSettings: baseUrl + "/settings/getSettings",
        urlAcceptSettings: baseUrl + "/settings/acceptSettings"
    },
    mounted: () => { setTimeout(() => { settings.getSettings() }, 100) },
    methods: {
        getSettings: async () => {
            const response = await fetch(settings.urlGetSettings)

            const body = await response.json()
            console.log(body)

            if (body) {
                settings.settings = body
            }
        },
        acceptSettings: async () => {
            const response = await fetch(settings.urlAcceptSettings, {
                method: "POST",
                body: JSON.stringify(settings.settings)
            })

            const body = await response.json()

            if (body.success) {
                settings.acceptMessage = "Настройки успешно применены"
                settings.messageStyle = "color: green;"
            }
            else {
                settings.acceptMessage = "При обновлении настроек произошёл сбой"
                settings.messageStyle = "color: red;"
            }
        }
    }
})