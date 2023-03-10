let hue = 0
let saturation = 100
let light = 50

let colorScreenOffsetTop = 0
let colorScreenOffsetLeft = 0
let colorSelectorOffsetLeft = 0

document.addEventListener("DOMContentLoaded", function()
{
    document.getElementById('color-screen').style.backgroundColor = "rgb(255, 0, 0)"
    document.getElementById('selected-color').style.backgroundColor = "rgb(255, 0, 0)"
    document.getElementById('hex').value = hsl2hex(0, 100, 50)

    colorScreenOffsetTop = document.getElementById('color-screen').offsetTop
    colorScreenOffsetLeft = document.getElementById('color-screen').offsetLeft
    colorSelectorOffsetLeft = document.getElementById('color-selector').offsetLeft

    let pickers = document.querySelectorAll(`[data-color-picker]`)
})

let pressed = false
let pressed2 = false

document.getElementById('color-selector').addEventListener('mousedown', function(e)
{
    pressed = true
    let cursorPosition = e.clientX
    let positionLeft = cursorPosition - colorSelectorOffsetLeft - 1.5

    //On récupère la valeur qui est au centre du sélecteur qui a une width de 6px (qu'on divise par 2 pour obtenir son centre)
    let value = positionLeft + 3

    document.getElementById('selector').style.left = positionLeft + 'px'
    hue = value
    changeColor(hue, saturation, light)
    changeScreen(hue)
})

document.querySelectorAll('#color-selector, body').forEach(function(e)
{
    this.addEventListener('mousemove', function(e)
    {   
        if (pressed)
        {
            let cursorPosition = e.clientX
            let positionLeft = cursorPosition - colorSelectorOffsetLeft - 1.5

            if (positionLeft >= 357)
                positionLeft = 357
            
            if (positionLeft <= -3)
                positionLeft = -3

            let value = positionLeft + 3
        
            document.getElementById('selector').style.left = positionLeft + 'px'
            hue = value
            changeColor(hue, saturation, light)
            changeScreen(hue)
        }
    })
})

document.getElementById('color-screen').addEventListener('mousedown', function(e)
{
    //On indique qu'il y a eu un clic sur la souris pour pouvoir faire bouger le sélecteur avec mousemove
    pressed2 = true

    //On récupère la position du curser pour placer le selecteur au bon endroit
    let cursorPositionX = e.clientX
    let cursorPositionY = e.clientY

    //On place le curseur au centre du selecteur
    let positionLeft = cursorPositionX - colorScreenOffsetLeft
    let positionTop = cursorPositionY - colorScreenOffsetTop
    document.getElementById('round-pointer').style.left = positionLeft + 'px'
    document.getElementById('round-pointer').style.top = positionTop + 'px'

    saturation = Math.ceil((positionLeft / 360) * 100)
    light = Math.ceil(((360 - positionTop) / 360) * 100)

    if (saturation + light > 100)
        light = Math.ceil(Math.ceil(light / 2) + ((100 - saturation) / 2))

    changeColor(hue, saturation, light)
})

document.querySelectorAll('#color-screen, body').forEach(function(e)
{
    this.addEventListener('mousemove', function(e)
    {  
        if (pressed2)
        {
            let cursorPositionX = e.clientX
            let cursorPositionY = e.clientY
        
            let positionLeft = cursorPositionX - colorScreenOffsetLeft
            let positionTop = cursorPositionY - colorScreenOffsetTop
        
            if (positionLeft >= 360)
                positionLeft = 360
        
            if (positionLeft <= 0)
                positionLeft = 0
                
            if (positionTop >= 360)
                positionTop = 360
        
            if (positionTop <= 0)
                positionTop = 0
        
            document.getElementById('round-pointer').style.left = positionLeft + 'px'
            document.getElementById('round-pointer').style.top = positionTop + 'px'
            saturation = Math.ceil((positionLeft / 360) * 100)
            light = Math.ceil(((360 - positionTop) / 360) * 100)
        
            if (saturation + light > 100)
                light = Math.ceil(Math.ceil(light / 2) + ((100 - saturation) / 2))
        
            changeColor(hue, saturation, light)
            e.stopPropagation()
        }
    })
})

document.addEventListener('mouseup', function()
{
    pressed = false
    pressed2 = false
})

document.getElementById('hex').addEventListener('change', function(e)
{
    let hex = e.target.value
    hex = hex.replace('#', '')
    this.value = hex
    let hsl = hex2hsl(hex)
    let h = hsl[0]
    let s = hsl[1]
    let l = hsl[2]

    hue = h
    saturation = s
    light = l

    changeScreen(h)
    changeColorHexa(hex)

    document.getElementById('selector').style.left = h + 'px'
    document.getElementById('round-pointer').style.left = Math.ceil((s / 100) * 360) + 'px'
    if (s + l < 88)
        document.getElementById('round-pointer').style.top = Math.ceil(((100 - l) / 100) * 360) + 'px'
    else
        document.getElementById('round-pointer').style.top = Math.ceil(((100 - (l * 2)) / 100) * 360) + 'px'
})

function changeScreen(h)
{
    let rgbcolor = hsl2rgb(h, 100, 50)
    document.getElementById('color-screen').style.backgroundColor = "rgb(" + rgbcolor[0] + "," + rgbcolor[1] + "," + rgbcolor[2] + ")"
}

function changeColorHexa(hex)
{
    document.getElementById('selected-color').style.backgroundColor = "#" + hex
}

function changeColor(h, s, l)
{
    if (h < 0)
        h = 0

    let rgbcolor = hsl2rgb(h, s, l)
    let hexcolor = hsl2hex(h, s, l)
    
    document.getElementById('selected-color').style.backgroundColor = "rgb(" + rgbcolor[0] + "," + rgbcolor[1] + "," + rgbcolor[2] + ")"
    document.getElementById('hex').value = hexcolor
}

/**
 * H : [0, 360]
 * S : [0, 100] 
 * L : [0, 100] 
 * Return value : [0, 255]
*/
function hsl2rgb(h, s, l)
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

function hsl2hex(h, s, l)
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

function hex2hsl(hex)
{
    hex = hex.replace('#', '')

    if (hex.length < 6)
    {
        while (hex.length != 6)
        {
            hex = hex + '0'
        }
        document.getElementById('hex').value = hex
    }

    if (hex.length > 6)
    {
        while (hex.length != 6)
        {
            hex = hex.slice(0, -1)
        }
        document.getElementById('hex').value = hex
    }

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