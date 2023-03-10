//Génération d'un nouveau projet
$(document).on('click', '.new-project', function()
{
    $.post(baseurl + 'home/new_project',
    function(data)
    {
        alert(data)
    })
})


$(document).on('input', '.csselement', function()
{
    var idcomponent = $('input[name="component"]').val()
    var idprojet = $('input[name="projet"]').val()
    var classname = '.A' + idprojet + '-' + $('.classname').val().replace('.', '')
    var main = '.' + $('[data-main="1"]').attr('class')
    var rule = $(this).attr('data-rule')
    var content = $(this).val()
    var unite = ($(this).attr('data-unite') != undefined) ? $(this).attr('data-unite') : ''

    if (rule.indexOf('box-shadow') != '-1')
    {
        var boxshadow = ''
        $('.box-shadow-' + idcomponent).each(function()
        {
            boxshadow += $(this).val()
            if ($(this).attr('data-unite') != null)
                boxshadow += $(this).attr('data-unite')
            boxshadow += ' '
        })

        rule = 'box-shadow'
        content = boxshadow.trim()
        unite = ''
    }

    //On change la valeur dans la BDD
    $.post(baseurl + 'projets/edit_component',
    {
        id_component: idcomponent,
        regle: rule,
        valeur: content,
        unite: unite
    })

    //On récupère le style de l'élément
    var elmtstyle = $('.elmt-style[data-id="' + idcomponent + '"]').html()

    //On supprime les éléments qui ne sont pas du style
    elmtstyle = elmtstyle.replace(classname, '')
    if (classname != main)
        elmtstyle = elmtstyle.replace(main, '') 
    elmtstyle = elmtstyle.replace('{', '')
    elmtstyle = elmtstyle.replace('}', '')

    //Séparation des règles
    elmtstyle = elmtstyle.split(';')
    tmp = []

    //Suppression des éléments vides
    for (var i = 0; i < elmtstyle.length; i++)
    {
        if (elmtstyle[i] != null && elmtstyle[i] != '')
            tmp.push(elmtstyle[i]) 
    }

    elmtstyle = tmp
    styles = {}

    for (var i = 0; i < elmtstyle.length; i++)
    {
        if (elmtstyle[i].replace(/\s+/g, '') != '')
        {
            var x = elmtstyle[i].split(':')
            styles[x[0].replace(/\s+/g, '')] = x[1]
        }
    }

    styles[rule] = content + unite

    var append = ''
    if (classname == main)
        append += classname + '\n'
    else
        append += main + classname + '\n'
    append += '{\n'

    for (const prop in styles)
    {
        append += prop + ' : ' + styles[prop] + ';\n'
    }

    append += '}\n'
    $('.elmt-style[data-id="' + idcomponent + '"]').html(append)
})

$(document).on('change', '.classname', function()
{
    if ($(this).val() != null && $(this).val() != '')
    {
        var idcomponent = $('input[name="component"]').val()
        var idprojet = $('input[name="projet"]').val()
        var main = $('[data-main="1"]').attr('class')
    
        $.post(baseurl + 'projets/edit_classname',
        {
            id_component: idcomponent,
            classname: $(this).val().replace('.', '')
        })
    
        var oldClass = $('#elmt-' + idcomponent).attr('class')
        oldClass = '.' + oldClass.replace(' ', '.')

        //On vérifie qu'il s'agit ou non du main pour ajouter la classe du main au début
        //S'il s'agit du main on modifie toutes les fois où il apparait
        if ($('#elmt-' + idcomponent).attr('data-main') == 1)
        {
            var newClass = $(this).val().replace('.', '')
            $(oldClass).each(function()
            {
                var elmtClass = $(this).attr('class')
                $(this).attr('class', elmtClass.replace(oldClass.replace('.', ''), 'A' + idprojet + '-' + newClass))
            })
        }
        else
            $('#elmt-' + idcomponent).attr('class', main + ' A' + idprojet + '-' + $(this).val().replace('.', ''))
    
        //On récupère le style de l'élément
        var elmtstyle = $('.elmt-style[data-id="' + idcomponent + '"]').html()
    
        //On remplace le nom de la classe par le nouveau nom
        if ($('#elmt-' + idcomponent).attr('data-main') == 1)
        {
            var newClass = $(this).val().replace('.', '')
            $('.elmt-style').each(function()
            {
                $(this).html($(this).html().replace(oldClass, '.A' + idprojet + '-' + newClass))
            })
        }
        else
        {
            elmtstyle = elmtstyle.replace(oldClass, '.' + main + '.A' + idprojet + '-' + $(this).val().replace('.', ''))
            $('.elmt-style[data-id="' + idcomponent + '"]').html(elmtstyle)
        }
    
        showToast('success', 'Opération effectuée', 'Le nom de la classe a bien été modifié.')
    }
    else
        showToast('error', 'Erreur lors de l\'opération', 'Le nom de la classe ne peut pas être vide.')
})

function showToast(type, title, message)
{
    $('.toast').addClass('visible')
    $('.toast-header__type').addClass(type)
    $('.toast-header__title').html(title)
    $('.toast-body').html(message)
    
    setTimeout(function()
    {
        $('.toast').removeClass('visible')
        $('.toast-header__type').removeClass(type)
        $('.toast-header__title').html('')
        $('.toast-body').html('')
    }, 3000)
}