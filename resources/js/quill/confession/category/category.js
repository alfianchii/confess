import { quillTextEditor } from "../../../quill";

const config = [
    ["bold", "italic", "underline", "strike"],
    [{ color: [] }, { background: [] }],
    [{ script: "super" }, { script: "sub" }],
    ["clean"],
];

quillTextEditor("#editor", "description", "deskripsi kategori", config);
