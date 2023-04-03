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
    FilePond.create(document.querySelector(".image-crop-filepond"), {
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
}

export function imagePreview() {
    // Filepond: Image Preview
    FilePond.create(document.querySelector(".image-preview-filepond"), {
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
}
