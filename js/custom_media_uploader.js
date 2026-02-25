const media_upload_btn = document.querySelector('#stream_content_select');
const media_delete = document.querySelector('#stream_content_delete');
const stream_url = document.querySelector('.stream_content_input');
const content_preview = document.querySelector(
    '.stream_content__preview_field',
);

let mediaUploader;

if (media_upload_btn) {
    media_upload_btn.addEventListener('click', (evt) => {
        evt.preventDefault();

        // if (mediaUploader) {
        //     mediaUploader.open();
        //     return;
        // }

        mediaUploader = wp.media({
            title: 'メディアファイル選択',
            button: {
                text: '選択',
            },
            library: {
                type: ['video', 'audio'],
            },
            multiple: false,
        });

        mediaUploader.on('select', () => {
            const attachment = mediaUploader
                .state()
                .get('selection')
                .first()
                .toJSON();
            stream_url.setAttribute('value', attachment.url);
            content_preview.setAttribute('src', attachment.url);
        });

        mediaUploader.open();
    });
}

if (media_delete) {
    media_delete.addEventListener('click', () => {
        stream_url.setAttribute('value', '');
        content_preview.setAttribute('src', '');
    });
}

const media_img_upload_btn = document.querySelector('#stream_img_select');
const media_img_delete = document.querySelector('#stream_img_delete');
const stream_img_url = document.querySelector('.stream_img_input');
const preview_img = document.querySelector('.stream_img__preview_field');

if (media_img_upload_btn) {
    media_img_upload_btn.addEventListener('click', (evt) => {
        evt.preventDefault();

        mediaUploader = wp.media({
            title: 'メディアファイル選択',
            button: {
                text: '選択',
            },
            library: {
                type: 'image',
            },
            multiple: false,
        });

        mediaUploader.on('select', () => {
            const attachment = mediaUploader
                .state()
                .get('selection')
                .first()
                .toJSON();
            stream_img_url.setAttribute('value', attachment.url);
            preview_img.setAttribute('src', attachment.url);
        });

        mediaUploader.open();
    });
}

if (media_img_delete) {
    media_img_delete.addEventListener('click', () => {
        stream_img_url.setAttribute('value', '');
        preview_img.setAttribute('src', '');
    });
}

const js_section = document.querySelector('.add_js_file__select_file_section');
const add_js_btn = document.querySelector('#add_js_file__btn');
const remove_js_btn = document.querySelector('#remove_js_file__btn');

let json_data = null;

const data = {
    post_id: jsf_counter.post_id,
    count: jsf_counter.count,
};

async function get_jsf_counter() {
    if (json_data) return json_data;

    const res = await fetch(
        jsf_counter.resturl + 'json_delivery/v1/receive-data',
        {
            headers: {
                'X-WP-Nonce': jsf_counter.nonce,
            },
        },
    );
    const data = await res.json();

    json_data = JSON.stringify(data.data);
    // console.log(data);
    return json_data;
}

async function post_jsf_counter() {
    fetch(jsf_counter.resturl + 'json_delivery/v1/receive-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': jsf_counter.nonce,
        },
        body: JSON.stringify(data),
    })
        .then((res) => res.json())
        .then((data) => {
            console.log(data);
        })
        .catch((err) => console.error(err));
}
console.log(data['count']);
let js_file_url = [];
let div = [];
let label = [];
let input = [];
let button_select = [];
let button_delete = [];
let display_file_name = [];

let jsf_select_btn_arr = [];
let jsf_delete_btn_arr = [];

if (add_js_btn) {
    add_js_btn.addEventListener('click', () => {
        data['count'] >= 10 ? 10 : data['count']++;

        if (data['count'] < 10) {
            div[data['count']] = document.createElement('div');
            div[data['count']].className =
                'additional_js_file__section' + data['count'];
            div[data['count']].style.cssText =
                'border-bottom:1px solid black; padding:8px; margin-bottom:16px;';

            label[data['count']] = document.createElement('label');
            label[data['count']].htmlFor =
                'additional_js_file__input' + data['count'];
            label[data['count']].textContent =
                '追加JavaScriptファイル' + data['count'];
            label[data['count']].style.marginRight = '8px';

            input[data['count']] = document.createElement('input');
            input[data['count']].type = 'hidden';
            input[data['count']].value = js_file_url[data['count']] ?? '';
            input[data['count']].className =
                'additional_js_file__input' + data['count'];
            input[data['count']].name =
                'additional_js_file__input' + data['count'];

            button_select[data['count']] = document.createElement('button');
            button_select[data['count']].className =
                'additional_js_file__btn--select' + data['count'];
            button_select[data['count']].textContent = '選択';
            button_select[data['count']].style.marginRight = '8px';

            button_delete[data['count']] = document.createElement('button');
            button_delete[data['count']].className =
                'additional_js_file__btn--delete' + data['count'];
            button_delete[data['count']].textContent = '削除';
            button_delete[data['count']].style.marginRight = '8px';

            display_file_name[data['count']] = document.createElement('p');
            display_file_name[data['count']].className =
                'additional_js_file__display' + data['count'];
            const text = get_display_name(js_file_url[data['count']]);
            display_file_name[data['count']].textContent =
                'ファイル名： ' + text;

            if (post_jsf_counter()) {
                console.log(data['count']);

                div[data['count']].appendChild(label[data['count']]);
                div[data['count']].appendChild(input[data['count']]);
                div[data['count']].appendChild(button_select[data['count']]);
                div[data['count']].appendChild(button_delete[data['count']]);
                div[data['count']].appendChild(
                    display_file_name[data['count']],
                );
                js_section.appendChild(div[data['count']]);
            } else {
                data['count']--;
            }

            get_jsf_select_element();
            select_js_file();
            delete_js_file();
        }
    });
}

if (remove_js_btn) {
    remove_js_btn.addEventListener('click', () => {
        data['count'] <= 0 ? 0 : data['count']--;
        if (post_jsf_counter()) {
            if (js_section) js_section.lastElementChild.remove();
            console.log(js_section.lastElementChild);

            console.log(data['count']);
        } else {
            data['count']++;
        }
    });
}

function get_jsf_select_element() {
    jsf_input_arr = document.querySelectorAll(
        "input[class^='additional_js_file__input']",
    );
    jsf_display_arr = document.querySelectorAll(
        "p[class^='additional_js_file__display']",
    );
    jsf_select_btn_arr = document.querySelectorAll(
        "button[class^='additional_js_file__btn--select']",
    );
    jsf_delete_btn_arr = document.querySelectorAll(
        "button[class^='additional_js_file__btn--delete']",
    );
}

function get_display_name(url = '') {
    return url !== '' && url != null
        ? url.substring(url.lastIndexOf('/') + 1)
        : '';
}

function get_element_classname_last_letter(elm) {
    return elm.className.slice(-1);
}

function select_js_file() {
    if (jsf_select_btn_arr) {
        jsf_select_btn_arr.forEach((btn, i) => {
            let mediaUploader;

            btn.addEventListener('click', (evt) => {
                evt.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: 'メディアファイル選択',
                    button: {
                        text: '選択',
                    },
                    library: {
                        // type: 'text/javascript',
                    },
                    multiple: false,
                });

                const num = get_element_classname_last_letter(btn);

                mediaUploader.on('select', () => {
                    const attachment = mediaUploader
                        .state()
                        .get('selection')
                        .first()
                        .toJSON();
                    js_file_url[num] = attachment.url;
                    jsf_input_arr[i].setAttribute('value', js_file_url[num]);
                    jsf_display_arr[i].textContent =
                        'ファイル名： ' + get_display_name(js_file_url[num]);
                    console.log(jsf_input_arr[i].value);
                });

                mediaUploader.open();

                console.log(js_file_url[num]);
            });
        });
    }
}

function delete_js_file() {
    if (jsf_delete_btn_arr) {
        jsf_delete_btn_arr.forEach((btn, i) => {
            btn.addEventListener('click', () => {
                const num = get_element_classname_last_letter(btn);

                jsf_input_arr[i].setAttribute('value', '');
                jsf_display_arr[i].textContent = 'ファイル名： ';

                js_file_url[num] = '';
            });
        });
    }
}

get_jsf_select_element();
select_js_file();
delete_js_file();
