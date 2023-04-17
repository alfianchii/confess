const defaultConfig = {
    toolbar: [
        [{ font: [] }],
        [{ align: [] }],
        ["bold", "italic", "underline", "strike"],
        [
            { list: "ordered" },
            { list: "bullet" },
            { indent: "-1" },
            { indent: "+1" },
        ],
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ color: [] }, { background: [] }],
        ["blockquote", "code-block"],
        [{ script: "super" }, { script: "sub" }],
        ["clean"],
    ],
};

export function quillTextEditor(
    element,
    body,
    text,
    quillModules = defaultConfig,
    quillTheme = "snow"
) {
    let quill = new Quill(element, {
        bounds: "#editor-container .editor",
        modules: quillModules,
        theme: quillTheme,
        placeholder: `Tuliskan ${text} di sini ...`,
    });

    function updateBody() {
        document.getElementById(body).value = quill.root.innerHTML;
    }

    quill.on("text-change", updateBody);
}
