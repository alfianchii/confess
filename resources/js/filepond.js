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

// Filepond: Image Crop
export function imageCrop() {
    const images = document.querySelectorAll(".image-crop-filepond");

    images.forEach((image) => {
        FilePond.create(image, {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: true,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type);
                }),
            storeAsFile: true,
            imageCropAspectRatio: "1:1",
        });
    });
}

// Filepond: Image Preview
export function imagePreview() {
    const images = document.querySelectorAll(".image-preview-filepond");

    images.forEach((image) => {
        FilePond.create(image, {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type);
                }),
            storeAsFile: true,
        });
    });
}
