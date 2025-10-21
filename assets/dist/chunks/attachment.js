import { useUnicorn, module, fadeOut, useUniDirective, injectCssToDocument } from "@windwalker-io/unicorn-next";
const css = ".c-attachment-uploader {\n  position: relative;\n  display: inline-block;\n  width: 100%;\n  min-height: 100px;\n  cursor: pointer;\n}\n.c-attachment-uploader input {\n  position: absolute;\n  z-index: 2;\n  width: 100%;\n  margin: 0;\n  overflow: hidden;\n  opacity: 0;\n  height: 100%;\n  cursor: pointer;\n}\n.c-attachment-uploader input.hover + label {\n  border-color: #333;\n}\n.c-attachment-uploader label {\n  position: relative;\n  top: 0;\n  bottom: 0;\n  left: 0;\n  right: 0;\n  z-index: 1;\n  padding: 0.375rem 0.75rem;\n  color: #495057;\n  background-color: #fff;\n  border: 1px solid #ced4da;\n  border-radius: 0.25rem;\n  height: 100px;\n  text-align: center;\n  display: flex;\n  align-items: center;\n  transition: border-color 0.3s;\n  cursor: pointer;\n}\n.c-attachment-uploader label > div {\n  display: inline-block;\n  width: 100%;\n}\n.c-attachment-uploader label::after {\n  content: none !important;\n}\n\n.c-attachment-list__item {\n  transition: all 0.3s ease-in-out;\n}\n.c-attachment-list__item.hide {\n  height: 0;\n  visibility: collapse;\n}";
class AttachmentHandler {
  constructor(el, options) {
    this.el = el;
    this.options = options;
    this.init(this.el, this.options);
  }
  init(el, options) {
    const u = useUnicorn();
    const removeBtns = el.querySelectorAll("[data-remove-btn]");
    const insertBtns = el.querySelectorAll("[data-insert-btn]");
    let sortable = options.sortable;
    if (sortable) {
      const sortableOptions = {
        sort: true,
        handle: ".c-handle"
      };
      import("sortablejs").then(({ default: Sortable }) => {
        module(
          el.querySelector("table tbody"),
          "attachment.sortable",
          (ele) => new Sortable(ele, sortableOptions)
        );
      });
    }
    insertBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        let a = document.createElement("a");
        const currentTarget = e.currentTarget;
        const href = currentTarget?.dataset.href;
        const fileName = currentTarget?.dataset.filename;
        a.setAttribute("target", "_blank");
        if (href) {
          a.setAttribute("href", href);
        }
        if (fileName) {
          a.innerText = fileName;
        }
        u.$ui.tinymce.get(btn.dataset.insertBtn || "#input-item-fulltext").insert(a.outerHTML);
      });
    });
    removeBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const currentTarget = e.currentTarget;
        let tr = currentTarget?.closest("tr");
        if (tr) {
          tr?.querySelector("[data-remove]")?.removeAttribute("disabled");
          fadeOut(tr);
        }
      });
    });
  }
}
async function init() {
  useUniDirective(
    "attachment-list",
    {
      mounted(el, { value }) {
        injectCssToDocument(document, css);
        const options = JSON.parse(value);
        module(el, "attachment", (el2) => new AttachmentHandler(el2, options));
      }
    }
  );
}
const ready = init();
export {
  AttachmentHandler,
  ready
};
//# sourceMappingURL=attachment.js.map
