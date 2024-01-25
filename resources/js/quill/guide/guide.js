import { quillTextEditor } from "../../quill";

const configs = [["link", "image", "video"]];
quillTextEditor("#editor", "body", "panduan", undefined, undefined, configs);
