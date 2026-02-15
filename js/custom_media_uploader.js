const media_upload_btn = document.querySelector('#stream_content_select');
const media_delete = document.querySelector('#stream_content_delete');
const stream_url = document.querySelector('.stream_content_input');
const content_preview = document.querySelector(
    '.stream_content__preview_field',
);

let mediaUploader;

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

media_delete.addEventListener('click', () => {
    stream_url.setAttribute('value', '');
    content_preview.setAttribute('src', '');
});

const media_img_upload_btn = document.querySelector('#stream_img_select');
const media_img_delete = document.querySelector('#stream_img_delete');
const stream_img_url = document.querySelector('.stream_img_input');
const preview_img = document.querySelector('.stream_img__preview_field');

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

media_img_delete.addEventListener('click', () => {
    stream_img_url.setAttribute('value', '');
    preview_img.setAttribute('src', '');
});
