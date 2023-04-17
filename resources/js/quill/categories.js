import { quillTextEditor } from "../quill";

const config = {
    toolbar: [
        ["bold", "italic", "underline", "strike"],
        [{ color: [] }, { background: [] }],
        [{ script: "super" }, { script: "sub" }],
        ["clean"],
    ],
};

quillTextEditor("#editor", "description", "deskripsi kategori", config);
