// Plugins
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageCrop,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageFilter,
    FilePondPluginImageResize,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType
);

const imageExtensions = [
    "image/png",
    "image/jpg",
    "image/jpeg",
    "image/heic",
    "image/heif",
];

// Filepond: Image Crop
export function imageCrop() {
    const images = document.querySelectorAll(".image-crop-filepond");

    images.forEach((image) =>
        FilePond.create(image, {
            name: "image",
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: true,
            allowFileEncode: false,
            acceptedFileTypes: imageExtensions,
            maxFileSize: "10MB",
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type);
                }),
            storeAsFile: true,
            imageCropAspectRatio: "1:1",
        })
    );
}

// Filepond: Image Preview
export function imagePreview() {
    const images = document.querySelectorAll(".image-preview-filepond");

    images.forEach((image) =>
        FilePond.create(image, {
            name: "image",
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            allowFileEncode: false,
            maxFileSize: "10MB",
            acceptedFileTypes: imageExtensions,
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type);
                }),
            storeAsFile: true,
        })
    );
}

// Filepond: Basic File
export function basicFile() {
    const files = document.querySelectorAll(".basic-file-filepond");

    files.forEach((file) =>
        FilePond.create(file, {
            name: "file",
            credits: null,
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: false,
            storeAsFile: true,
        })
    );
}
