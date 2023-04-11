let quill = new Quill("#editor", {
    bounds: "#editor-container .editor",
    modules: {
        toolbar: [
            [
                {
                    font: [],
                },
                {
                    size: [],
                },
                { header: 1 },
                { header: 2 },
            ],
            ["bold", "italic", "underline", "strike"],
            [
                {
                    color: [],
                },
                {
                    background: [],
                },
            ],
            ["blockquote", "code-block"],
            [
                {
                    script: "super",
                },
                {
                    script: "sub",
                },
            ],
            [
                {
                    list: "ordered",
                },
                {
                    list: "bullet",
                },
                {
                    indent: "-1",
                },
                {
                    indent: "+1",
                },
            ],
            [
                "direction",
                {
                    align: [],
                },
            ],
            ["link"],
            ["clean"],
        ],
    },
    theme: "snow",
    placeholder: "Tuliskan keluhan kamu di sini ...",
});

function updateBody() {
    document.getElementById("body").value = quill.root.innerHTML;
}

quill.on("text-change", updateBody);
