var templates_container = document.querySelector('#templates');
var templates = document.querySelectorAll('#templates .template_card');

var templatePerPage = 12;
var nombre_page = templates.length/templatePerPage;


var pagination_ul = document.querySelector('.pagination');

var pagination_li = "<li class='page-item disabled'><a class='page-link' href='#title_templates'>Précédent</a></li>";

pagination_ul.innerHTML +=  pagination_li;

if(nombre_page % 1 != 0)
{
    nombre_page += 1 - (nombre_page % 1);
}

for(var i = 1; i <= nombre_page; i++)
{
    var classe_item;
    if(i == 1)
        classe_item = 'page-item active';
    else
        classe_item = 'page-item';

    var pagination_li = "<li class='" + classe_item + "'><a class='page-link' href='#title_templates'>" + i +"</a></li>";
    
    pagination_ul.innerHTML +=  pagination_li;
    
}

var pagination_li = "<li class='next_link page-item'><a class='page-link' href='#title_templates'>Suivant</a></li>";

pagination_ul.innerHTML +=  pagination_li;

afficher_template(0, templatePerPage-1);

var page_links = pagination_ul.querySelectorAll('.page-link');


var page_courante = 1;

for(var i = 0; i < page_links.length; i++)
{
    page_links[i].addEventListener('click', function() 
    {
        switch(this.innerHTML)
        {
            case "Précédent":
                if(page_courante > 1)
                    page_courante--;
                break;
            case "Suivant":
                if(page_courante < nombre_page)
                    page_courante++;
                break;   
            default:
                page_courante = parseInt(this.innerHTML);
        }
        var ex_active = pagination_ul.querySelector('.active');
        
        ex_active.classList.remove('active');

        if(page_courante == 1)
        {
            page_links[page_links.length-1].parentElement.classList.remove('disabled');
            page_links[0].parentElement.classList.add('disabled');
        }
        else if(page_courante == nombre_page)
        {
            page_links[0].parentElement.classList.remove('disabled');
            page_links[page_links.length-1].parentElement.classList.add('disabled');
        }
        else
        {
            page_links[0].parentElement.classList.remove('disabled');
            page_links[page_links.length-1].parentElement.classList.remove('disabled');
        }

        page_links[page_courante].parentElement.classList.add('active');

        afficher_template((page_courante-1) * templatePerPage, ((page_courante-1) * templatePerPage)+templatePerPage-1 );
    });
}



function afficher_template(debut, fin)
{
    templates_container.innerHTML = '';
    for(var i = debut; i <= fin && i < templates.length ; i++)
    {
        templates_container.appendChild(templates[i]);
    }
}