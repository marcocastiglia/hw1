/* Sezione per pubblicare il post */

function onResponse(response) {
    return response.json();
}

function show_article(article) {
    for(let ar of allArticles) {
        ar.classList.remove('show_flex');
        ar.classList.add('hidden');
    }
    article.classList.add('show_flex');
    article.classList.remove('hidden');
}

function resetScriviForm(event) {
    document.querySelector('article.scrivi p.alarms').classList.add('hidden');
    document.querySelector('.add_ingr img').src = './images/add_icon.png';
    document.querySelector('.add_ingr img').addEventListener('click',moreIngredients);
    document.querySelector('.more_ingr').innerHTML = '';
    document.querySelector('#image_results').innerHTML = '';
}

function fetchPost_update(){
    fetch('http://localhost/HW1/private_area/fetch_post.php').then(onResponse).then(updatePosts);
}

function onPublishedPost(json) {
    if(json == 'TRUE') {
        fetchPost_update();
        show_article(document.querySelector('#mainspace article.profilo'));
    }
}

function addPost(event) {
    const p_alarm = document.querySelector('article.scrivi p.alarms');

    if(scrivi_form.title.value.length === 0 ||
        scrivi_form.textarea.value.length === 0) {       
        p_alarm.textContent = 'Per pubblicare bisogna scrivere titolo e descrizione.';
        p_alarm.classList.add('error');
        p_alarm.classList.remove('hidden');

    } else {
        const form_data = {
            method: 'post',
            body: new FormData(scrivi_form)
        };

        fetch('http://localhost/HW1/private_area/create_post.php', form_data).then(onResponse).then(onPublishedPost);
   
    }
    event.preventDefault();
}

//Aggiorno i post
function updatePosts(json) {
    const posts_section = document.querySelector('.profilo .post_section');
    posts_section.innerHTML = '';
    for(let rec of json.recipes) {
        const post_div = document.createElement('div');
        post_div.classList.add('post_div');
        post_div.dataset.post_id = rec.id;

        const rec_title = document.createElement('span');
        rec_title.classList.add('rec_title');
        rec_title.textContent = rec.title;
        post_div.appendChild(rec_title);

        const ingr_list = document.createElement('div');
        ingr_list.classList.add('ingr_list');
        let count = 0;
        for(let ingr of json.ingredients) {
            if(ingr.recipe === rec.id) {
                const single_ingr = document.createElement('div');
                single_ingr.textContent = ingr.name;
                ingr_list.appendChild(single_ingr);
                count++;
            }
        }
        if(count === 0) {
            const single_ingr = document.createElement('div');
            single_ingr.textContent = 'No ingredients found';
            ingr_list.appendChild(single_ingr);
        }
        post_div.appendChild(ingr_list);

        const descr = document.createElement('p');
        descr.classList.add('descr');
        descr.textContent = rec.text;
        post_div.appendChild(descr);

        const image = document.createElement('img');
        if(rec.image == null || rec.image.length == 0) {
            image.src = './images/post_image_default.jpg';
        } else {
            image.src = rec.image;
        }     
        post_div.appendChild(image);

        const nlike_ncomment = document.createElement('div');
        nlike_ncomment.classList.add('nlike_ncomment');
        const nlikes = document.createElement('div');
        nlikes.classList.add('nlikes');
        nlikes.textContent = 'Likes: ' + rec.nlikes;
        nlike_ncomment.appendChild(nlikes);
        const ncomments = document.createElement('div');
        ncomments.classList.add('ncomments');
        ncomments.textContent = 'Comments: ' + rec.ncomments;
        nlike_ncomment.appendChild(ncomments);
        post_div.appendChild(nlike_ncomment);

        const button = document.createElement('button');
        button.classList.add('delete_post');
        button.textContent = 'Elimina Post';
        button.addEventListener('click',confirm_deletePost);
        post_div.appendChild(button);

        posts_section.appendChild(post_div);
    }  
    if(posts_section.innerHTML == '') {
        const h2 = document.createElement('h2');
        h2.textContent = 'Non hai ancora pubblicato alcuna ricetta.';
        h2.classList.add('error');
        posts_section.appendChild(h2);
    }
}

function confirm_deletePost(event) {
    //Mostra la modale
    document.querySelector('.profilo .modal_view .container div').innerHTML = '';

    const post_div = event.currentTarget.parentNode;
    const title = post_div.querySelector('.rec_title').cloneNode(true);
    const image = post_div.querySelector('img').cloneNode();
    
    const div = post_div.cloneNode();
    div.appendChild(title);
    div.appendChild(image);
    
    document.querySelector('.profilo .modal_view .container div').appendChild(div);
    document.querySelector('.profilo .modal_view').classList.remove('hidden');

    document.querySelector('.profilo .modal_view .container .confirm').addEventListener('click',delete_post);
    document.querySelector('.profilo .modal_view .container .cancel').addEventListener('click',dont_delete_post);

    document.querySelector('body').classList.add('hideOverflow');
}

function delete_post(event){
    const post = document.querySelector('.modal_view .post_div');

    const body_data = new FormData();
    body_data.append('id',post.dataset.post_id);
    const form_data = {
        method: 'post',
        body: body_data
    };
    fetch('http://localhost/HW1/private_area/delete_post.php', form_data).then(fetchPost_update);

    dont_delete_post();
}

function dont_delete_post(event){
    document.querySelector('.profilo .modal_view').classList.add('hidden');
    document.querySelector('body').classList.remove('hideOverflow');
}


function onClick_Display(event) {
    const className = event.currentTarget.classList.value;
    const str = '#mainspace article.' + className;
    const article = document.querySelector(str);
    show_article(article);
}


/* Sezione Options */
function displayOptions(event) {
    const h4 = options.querySelectorAll('a h4');
    for(let elem of h4) {
        elem.classList.remove('hidden');
    }
}
function hideOptions(event) {
    const h4 = options.querySelectorAll('a h4');
    for(let elem of h4) {
        elem.classList.add('hidden');
    }
}

const options = document.querySelector('#options');
options.addEventListener('mouseover', displayOptions);
options.addEventListener('mouseleave',hideOptions);


fetchPost_update();

function update_pro_pic(json) {
    if(json.pro_gif !== null)
        document.querySelector('.profilo img').src = json.pro_gif;
}
fetch('http://localhost/HW1/private_area/fetch_pro_gif.php').then(onResponse).then(update_pro_pic);


const allArticles = document.querySelectorAll('#mainspace article');

const scrivi_section = document.querySelector('#options .scrivi');
scrivi_section.addEventListener('click', onClick_Display);
const scrivi_form = document.forms['scrivi_form'];
scrivi_form.addEventListener('submit', addPost);
scrivi_form.addEventListener('reset',resetScriviForm);


/* Sezione Ingredients */
function remove_moreIngredients(event) {
    const div = event.currentTarget.parentNode;
    document.querySelector('.ingredients .more_ingr').removeChild(div);
}

function moreIngredients(event){
    event.currentTarget.src = './images/remove_icon.png';
    event.currentTarget.removeEventListener('click', moreIngredients);
    event.currentTarget.addEventListener('click', remove_moreIngredients);

    const div = document.createElement('div');
    div.classList.add('add_ingr');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'ingredient[]';
    div.appendChild(input);
    const image = document.createElement('img');
    image.src = './images/add_icon.png';
    image.addEventListener('click', moreIngredients);
    div.appendChild(image);

    document.querySelector('.ingredients .more_ingr').appendChild(div);
}

const add_ingr = document.querySelector('.add_ingr img');
add_ingr.addEventListener('click', moreIngredients);

function selectImage(event) {
    const img = event.currentTarget;
    const div_images = document.querySelectorAll('#image_results img');
    for(let el of div_images) {
        el.classList.remove('image_selected');
    }
    img.classList.add('image_selected');
    document.querySelector('.search_image_to_insert .search input').value = img.src;
}

function printImages(json) {
    console.log(json);

    const image_results = document.querySelector('#image_results');
    image_results.innerHTML = '';
    for(let i = 0; i<json.length; i++) {
        const image = document.createElement('img');
        image.src = json[i];
        image.addEventListener('click',selectImage);
        image_results.appendChild(image);
    }
}

function onSearchImage(event){
    event.preventDefault();
    const q = encodeURIComponent(document.querySelector('.search_image_to_insert .search input').value);
    fetch('http://localhost/HW1/private_area/search_image_post.php?q='+q).then(onResponse).then(printImages);
}

const button_image = document.querySelector('.search_image_to_insert button');
button_image.addEventListener('click',onSearchImage);

//Article Profilo
const profilo_section = document.querySelector('#options .profilo');
profilo_section.addEventListener('click', onClick_Display);



//Article Modifica
function displayError(json){
    console.log(json);
    const p_error = document.querySelector('article.modifica .confirm_pw p');
    const a = document.querySelector('article.modifica .confirm_pw a');
    if(!json) {
        p_error.textContent = 'Password errata';
        p_error.classList.remove('hidden');
    } else {
        p_error.classList.add('hidden');

        /* Si potrebbe accedere comunque alla pagina,
            basterebbe copiare questo link... */
        a.href ='modify_account.php?valid=true';
        a.classList.remove('hidden');
        a.classList.add('show_flex');
    }
}

function verify_pw(event){
    if(form_modifica.password.value.length > 8) {
        const form_data = {
            method:'post',
            body: new FormData(form_modifica)
        }
        fetch('http://localhost/HW1/private_area/verify_pw.php', form_data).then(onResponse).then(displayError);
    } else {
        const p_error = document.querySelector('article.modifica .confirm_pw p');
        p_error.textContent = 'Sicuramente sbagliata...(min 9 caratteri)';
        p_error.classList.remove('hidden');
    }
    event.preventDefault();
}

const modifica_section = document.querySelector('#options .modifica');
modifica_section.addEventListener('click', onClick_Display);
const form_modifica = document.forms['confirm_pw'];
form_modifica.addEventListener('submit', verify_pw);





/* Sezione Api immagine profilo */
function fetch_upload_gif(event) {
    const form_data = {
        method:'post',
        body: new FormData(form_giphy)
    };
    fetch('http://localhost/HW1/private_area/fetch_upload_gif.php',form_data).then(update_pro_pic);

    form_giphy.keyword.value = '';
    form_upload_gif.classList.add('hidden');
    document.querySelector('#gif_results').innerHTML = '';
}

function selectGif(event) {
    const img = event.currentTarget;
    const images = document.querySelectorAll('#gif_results img');
    for(let el of images) {
        el.classList.remove('image_selected');
    }
    img.classList.add('image_selected');
    document.querySelector('.container_gifs .text').value = img.src;
}

function printGifs(json) {
    const gif_results = document.querySelector('#gif_results');
    gif_results.innerHTML = '';
    for(let url of json) {
        const image = document.createElement('img');
        image.src = url;
        image.addEventListener('click',selectGif);
        gif_results.appendChild(image);
    }
    form_upload_gif.classList.remove('hidden');
}

function fetch_giphy(event) {
    event.preventDefault();
    const form_data = {
        method: 'post',
        body: new FormData(form_giphy)
    }
    fetch('http://localhost/HW1/private_area/fetch_giphy.php', form_data).then(onResponse).then(printGifs);
}

const pro_gif_section = document.querySelector('#options .pro_gif');
pro_gif_section.addEventListener('click', onClick_Display);
const form_giphy = document.forms['form_giphy'];
form_giphy.addEventListener('submit', fetch_giphy);

const form_upload_gif = document.forms['upload_gif'];
form_upload_gif.addEventListener('submit',fetch_upload_gif);




