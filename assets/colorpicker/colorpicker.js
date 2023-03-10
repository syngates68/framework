class ColorPicker
{
    hue = 0
    saturation = 0
    light = 0
    rgb = []
    hexa = null
    initialValue = '#FF0000'

    init(id, hexa = null)
    {
        //On définit l'id à trigger
        let picker = '#color-picker-' + id

        if (hexa == null || hexa == '')
            hexa = '#FF0000'

        if (hexa.length < 7)
        {
            while (hexa.length != 7)
            {
                hexa = hexa + '0'
            }
            document.querySelector(picker + ' #hex').value = hexa
        }

        if (hexa.length > 7)
        {
            while (hexa.length != 7)
            {
                hexa = hexa.slice(0, -1)
            }
            document.querySelector(picker + ' #hex').value = hexa
        }

        this.initialValue = hexa

        let hsl = this.hex2hsl(hexa)

        this.hue = hsl[0]
        this.saturation = hsl[1]
        this.light = hsl[2]

        this.rgb = this.hsl2rgb(this.hue, this.saturation, this.light)
        this.hexa = hexa
    }

    hsl2rgb(h, s, l)
    {
        h = (h == 360) ? 0 : h
        s /= 100
        l /= 100
        const k = n => (n + h / 30) % 12
        const a = s * Math.min(l, 1 - l)
        const f = n =>
            l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)))

        return [255 * f(0), 255 * f(8), 255 * f(4)]
    }

    hex2hsl(hex)
    {
        hex = hex.replace('#', '')

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)

        var r = parseInt(result[1], 16)
        var g = parseInt(result[2], 16)
        var b = parseInt(result[3], 16)

        r /= 255, g /= 255, b /= 255
        var max = Math.max(r, g, b), min = Math.min(r, g, b)
        var h, s, l = (max + min) / 2

        if(max == min)
            h = s = 0
        else 
        {
            var d = max - min
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min)
            switch(max) 
            {
                case r: 
                    h = (g - b) / d + (g < b ? 6 : 0)
                    break
                case g: 
                    h = (b - r) / d + 2
                    break
                case b: 
                h = (r - g) / d + 4
                break
            }

            h /= 6
        }

        s = s * 100
        s = Math.round(s)
        l = l * 100
        l = Math.round(l)
        h = Math.round(360*h)

        return [h, s, l]
    }

    hsl2hex(h, s, l)
    {
        l /= 100
        const a = s * Math.min(l, 1 - l) / 100
        const f = n => {
            const k = (n + h / 30) % 12
            const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1)
            return Math.round(255 * color).toString(16).padStart(2, '0')
        }

        return `${f(0).toUpperCase()}${f(8).toUpperCase()}${f(4).toUpperCase()}`
    }

    hsl2hsv(h, s, l) {

        const hsv1 = s * (l < 50 ? l : 100 - l) / 100
    
        const hsvS = hsv1 === 0 ? 0 : 2 * hsv1 / (l + hsv1) * 100
    
        const hsvV = l + hsv1
    
        return [ h, hsvS, hsvV ]
    
    }

    createSelectedColor(id)
    {
        return '<div class="selected-color" id="selected-color-' + id + '" data-id="' + id + '">'
        + '</div>'
    }

    createPicker(id)
    {
        return '<div class="color-picker" id="color-picker-' + id + '">'
        + '<div class="color-screen" id="color-screen">'
        + '<div class="hover hover1"></div>'
        + '<div class="hover hover2"></div>'
        + '<div class="round-pointer" id="round-pointer">'
        + '<div class="round-selector" id="round-selector"></div>'
        + '<div class="round-selector-2" id="round-selector-2"></div>'
        + '</div>'
        + '</div>'
        + '<div class="color-selector" id="color-selector">'
        + '<div class="selector" id="selector">'
        + '<div class="pointer" id="pointer"></div>'
        + '</div>'
        + '</div>'
        + '<div class="hexa-selector" id="hexa-selector">'
        + '<input type="text" name="hex" id="hex" class="hex" max="7">'
        + '</div>'
        + '<div class="buttons">'
        + '<button class="button button-valid" data-id="' + id + '">Valider</button>'
        + '<button class="button button-close" data-id="' + id + '">Fermer</button>'
        + '</div>'
        + '</div>'
    }

    changeColor(h, s, l, id)
    {
        this.hue = h
        this.saturation = s
        this.light = l

        let idselector = id.replace('color-picker-', '')
        if (h < 0)
            h = 0

        let rgbcolor = this.hsl2rgb(h, s, l)
        let hexcolor = this.hsl2hex(h, s, l)
        
        document.querySelector('#selected-color-' + idselector).style.backgroundColor = "rgb(" + rgbcolor[0] + "," + rgbcolor[1] + "," + rgbcolor[2] + ")"
        document.querySelector('#' + id + ' #hex').value = hexcolor
    }

    changeScreen(h, id)
    {
        this.hue = h

        let rgbcolor = this.hsl2rgb(h, 100, 50)
        document.querySelector('#' + id + ' #color-screen').style.backgroundColor = "rgb(" + rgbcolor[0] + "," + rgbcolor[1] + "," + rgbcolor[2] + ")"
    }

    changeColorHexa(hex, id)
    {
        let idselector = id.replace('color-picker-', '')
        document.getElementById('selected-color-' + idselector).style.backgroundColor = "#" + hex
    }
}

document.addEventListener("rightopened", function()
{
    let pickers = document.querySelectorAll('input[data-color-picker]')
    let cp = []

    for (let i = 0; i < pickers.length; i++)
    {
        pickers[i].style.display = 'none'
        let id = pickers[i].getAttribute('id')
        let value = pickers[i].value
        cp[id] = {}
        cp[id] = new ColorPicker
        cp[id].init(id, value)
        document.getElementById(id).insertAdjacentHTML('afterend', cp[id].createSelectedColor(id))
        document.getElementById('selected-color-' + id).insertAdjacentHTML('afterend', cp[id].createPicker(id))

        document.querySelector('#color-picker-' + id + ' #hex').value = cp[id].hexa.replace('#', '')
        document.querySelector('#color-picker-' + id + ' #color-screen').style.backgroundColor = 'hsl(' + cp[id].hue + ', 100%, 50%)'
        document.querySelector('#selected-color-' + id).style.backgroundColor = 'rgb(' + cp[id].rgb[0] + ', ' + cp[id].rgb[1] + ', ' + cp[id].rgb[2] + ')'
    }

    let colors = document.getElementsByClassName('selected-color')

    let getDataId = function() 
    {
        //On ferme le picker ouvert s'il y en a un
        let pickers = document.querySelectorAll('.color-picker')
        let id = this.getAttribute('data-id')

        for (let i = 0; i < pickers.length; i++)
        {
            if (pickers[i].getAttribute('id').replace('color-picker-', '') != id)
                pickers[i].classList.remove('visible')
        }

        let picker = document.getElementById('color-picker-' + id)

        if (picker.classList.contains('visible'))
            picker.classList.remove('visible')
        else
        {
            picker.classList.add('visible')
            let width = document.querySelector('#color-picker-' + id + ' #color-screen').offsetWidth
            document.querySelector('#color-picker-' + id + ' #color-screen').style.height = width + 'px'

            let hsv = cp[id].hsl2hsv(cp[id].hue, cp[id].saturation, cp[id].light)
            
            document.querySelector('#color-picker-' + id + ' #round-pointer').style.left = Math.ceil((hsv[1] / 100) * width) + 'px'
            document.querySelector('#color-picker-' + id + ' #round-pointer').style.top = Math.ceil(width - (hsv[2] / 100) * width) + 'px'
            document.querySelector('#color-picker-' + id + ' #selector').style.left = Math.ceil((cp[id].hue / 360) * width) + 'px'
        }
            
    }

    for (let i = 0; i < colors.length; i++) 
    {
        colors[i].addEventListener('click', getDataId, false)
    }

    let pressed = false
    let pressed2 = false

    let colorSelectors = document.getElementsByClassName('color-selector')
    let colorScreens = document.getElementsByClassName('color-screen')
    let hexas = document.getElementsByClassName('hex')
    let buttonValid = document.getElementsByClassName('button-valid')
    let buttonClose = document.getElementsByClassName('button-close')

    for (let i = 0; i < colorSelectors.length; i++)
    {
        colorSelectors[i].addEventListener('mousedown', function(e)
        {
            let width = this.offsetWidth
            let picker = this.parentElement.getAttribute('id')
            let id = picker.replace('color-picker-', '')
            let colorSelectorOffsetLeft = document.querySelector('#' + picker + ' #color-selector').getBoundingClientRect().left
            
            pressed = true
            let cursorPosition = e.clientX
            let positionLeft = cursorPosition - colorSelectorOffsetLeft - 1.5
    
            //On récupère la valeur qui est au centre du sélecteur qui a une width de 6px (qu'on divise par 2 pour obtenir son centre)
            let value = ((positionLeft / width) * 360)  + 3
    
            document.querySelector('#' + picker + ' #selector').style.left = positionLeft + 'px'
            hue = value
            cp[id].changeColor(hue, cp[id].saturation, cp[id].light, picker)
            cp[id].changeScreen(hue, picker)
        }, false)

        colorSelectors[i].addEventListener('mousemove', function(e)
        {
            if (pressed)
            {
                let width = this.offsetWidth
                let picker = this.parentElement.getAttribute('id')
                let id = picker.replace('color-picker-', '')
                let colorSelectorOffsetLeft = document.querySelector('#' + picker + ' #color-selector').getBoundingClientRect().left
                let cursorPosition = e.clientX
                let positionLeft = cursorPosition - colorSelectorOffsetLeft - 1.5

                if (positionLeft >= (width - 3))
                    positionLeft = (width - 3)

                if (positionLeft <= -3)
                    positionLeft = -3

                //On récupère la valeur qui est au centre du sélecteur qui a une width de 6px (qu'on divise par 2 pour obtenir son centre)
                let value = ((positionLeft / width) * 360)  + 3

                document.querySelector('#' + picker + ' #selector').style.left = positionLeft + 'px'
                hue = value
                cp[id].changeColor(hue, cp[id].saturation, cp[id].light, picker)
                cp[id].changeScreen(hue, picker)
            }
        }, false)
    }

    for (let i = 0; i < colorScreens.length; i++)
    {
        colorScreens[i].addEventListener('mousedown', function(e)
        {
            let width = this.offsetWidth
            let picker = this.parentElement.getAttribute('id')
            let id = picker.replace('color-picker-', '')
            let colorScreenOffsetLeft = document.querySelector('#' + picker + ' #color-screen').getBoundingClientRect().left
            let colorScreenOffsetTop = document.querySelector('#' + picker + ' #color-screen').getBoundingClientRect().top
            
            pressed2 = true
            let cursorPositionX = e.clientX
            let cursorPositionY = e.clientY

            let positionLeft = cursorPositionX - colorScreenOffsetLeft
            let positionTop = cursorPositionY - colorScreenOffsetTop
            document.querySelector('#' + picker + ' #round-pointer').style.left = positionLeft + 'px'
            document.querySelector('#' + picker + ' #round-pointer').style.top = positionTop + 'px'
            
            saturation = Math.ceil((positionLeft / width) * 100)
            light = Math.ceil(((width - positionTop) / width) * 100)

            if (saturation + light > 100)
                light = Math.ceil(Math.ceil(light / 2) + ((100 - saturation) / 2))

            cp[id].changeColor(cp[id].hue, saturation, light, picker)
        }, false)

        colorScreens[i].addEventListener('mousemove', function(e)
        {
            if (pressed2)
            {
                let width = this.offsetWidth
                let picker = this.parentElement.getAttribute('id')
                let id = picker.replace('color-picker-', '')
                let colorScreenOffsetLeft = document.querySelector('#' + picker + ' #color-screen').getBoundingClientRect().left
                let colorScreenOffsetTop = document.querySelector('#' + picker + ' #color-screen').getBoundingClientRect().top
                
                let cursorPositionX = e.clientX
                let cursorPositionY = e.clientY

                let positionLeft = cursorPositionX - colorScreenOffsetLeft
                let positionTop = cursorPositionY - colorScreenOffsetTop

                if (positionLeft >= width)
                    positionLeft = width

                if (positionLeft <= 0)
                    positionLeft = 0

                if (positionTop >= width)
                    positionTop = width

                if (positionTop <= 0)
                    positionTop = 0

                document.querySelector('#' + picker + ' #round-pointer').style.left = positionLeft + 'px'
                document.querySelector('#' + picker + ' #round-pointer').style.top = positionTop + 'px'
                
                saturation = Math.ceil((positionLeft / width) * 100)
                light = Math.ceil(((width - positionTop) / width) * 100)
    
                if (saturation + light > 100)
                    light = Math.ceil(Math.ceil(light / 2) + ((100 - saturation) / 2))

                cp[id].changeColor(cp[id].hue, saturation, light, picker)
            }
        }, false)
    }

    for (let i = 0; i < hexas.length; i++)
    {
        hexas[i].addEventListener('change', function(e)
        {
            let picker = this.parentElement.parentElement.getAttribute('id')
            let id = picker.replace('color-picker-', '')
            let width = document.querySelector('#' + picker + ' #color-screen').offsetWidth

            let hex = e.target.value
            hex = hex.replace('#', '')
            let hsl = cp[id].hex2hsl(hex)
            let h = hsl[0]
            let s = hsl[1]
            let l = hsl[2]

            cp[id].hue = h
            cp[id].saturation = s
            cp[id].light = l

            cp[id].changeScreen(h, picker)
            cp[id].changeColorHexa(hex, picker)

            document.querySelector('#' + picker + ' #selector').style.left = h + 'px'
            document.querySelector('#' + picker + ' #round-pointer').style.left = Math.ceil((s / 100) * width) + 'px'
            if (s + l < 88)
                document.querySelector('#' + picker + ' #round-pointer').style.top = Math.ceil(((100 - l) / 100) * width) + 'px'
            else
                document.querySelector('#' + picker + ' #round-pointer').style.top = Math.ceil(((100 - (l * 2)) / 100) * width) + 'px'
        })
    }

    for (let i = 0; i < buttonValid.length; i++)
    {
        buttonValid[i].addEventListener('click', function()
        {
            let id = this.getAttribute('data-id')
            document.querySelector('#color-picker-' + id).classList.remove('visible')
            document.getElementById(id).setAttribute('value', '#' + document.querySelector('#color-picker-' + id + ' #hex').value)
            document.getElementById(id).value = '#' + document.querySelector('#color-picker-' + id + ' #hex').value
            document.getElementById(id).dispatchEvent(new Event('input', { bubbles: true }))
        })
    }

    for (let i = 0; i < buttonClose.length; i++)
    {
        buttonClose[i].addEventListener('click', function()
        {
            let id = this.getAttribute('data-id')
            document.querySelector('#selected-color-' + id).style.backgroundColor = cp[id].initialValue
            document.querySelector('#color-picker-' + id).classList.remove('visible')
        })
    }

    document.addEventListener('mouseup', function()
    {
        pressed = false
        pressed2 = false
    })
})