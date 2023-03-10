$(document).on('click', '.edit-component', function()
{
    if (!$(this).hasClass('disabled'))
    {
        var component = $(this).attr('data-component')
    
        $(this).removeClass('edit-component')
        $(this).addClass('close-edition')
        $(this).html('close')
    
        //On désactive tous les boutons d'édition
        $('.edit-component').each(function()
        {
            $(this).addClass('disabled')
        })
                
        $.post(baseurl + 'projets/editor/' + $(this).attr('data-project') + '/' + $(this).attr('data-type'),
        {
            component: component
        },
        function(data)
        {
            var windowWidth = $(window).width()
            var rightWidth = $('.right').width()
            var middleWidth = windowWidth - (rightWidth * 2) - 64
    
            $('.main').addClass('right-opened')
            $('.middle').css('flexBasis', middleWidth + 'px')
            $('.right').html(data)
            $('.right').addClass('visible')
            const event = new Event('rightopened')
            document.dispatchEvent(event)
        })
    }
})

$(document).on('click', '.close-edition', function()
{
    //On réactive tous les boutons d'édition
    $('.edit-component').each(function()
    {
        $(this).removeClass('disabled')
    })

    $(this).removeClass('close-edition')
    $(this).addClass('edit-component')
    $(this).html('edit_note')

    var windowWidth = $(window).width()
    var rightWidth = $('.right').width()
    var middleWidth = windowWidth - rightWidth

    $('.main').removeClass('right-opened')
    $('.middle').css('flexBasis', middleWidth + 'px')
    $('.right').html('')
    $('.right').removeClass('visible')
})

$(document).mouseup(function(e) 
{
    var container = $('.right')
    var close = $('.close-edition')

    if (!container.is(e.target) && container.has(e.target).length === 0 && !close.is(e.target) && close.has(e.target).length === 0) 
    {
        //On réactive tous les boutons d'édition
        $('.edit-component').each(function()
        {
            $(this).removeClass('disabled')
        })

        $('.close-edition').addClass('edit-component')
        $('.close-edition').html('edit_note')
        $('.close-edition').removeClass('close-edition')

        var windowWidth = $(window).width()
        var rightWidth = $('.right').width()
        var middleWidth = windowWidth - rightWidth

        $('.main').removeClass('right-opened')
        $('.middle').css('flexBasis', middleWidth + 'px')
        $('.right').html('')
        $('.right').removeClass('visible')
    }
})