import { useUniDirective, useUnicorn, module, fadeOut, injectCssToDocument, useTinymce } from '@windwalker-io/unicorn-next';
import css from '../scss/attachment.scss?inline';

export interface AttachmentOptions {
  sortable?: boolean;
}

export class AttachmentHandler {

  constructor(protected el: HTMLElement, protected options: AttachmentOptions) {
    this.init(this.el, this.options);
  }

  init(el: HTMLElement, options: AttachmentOptions) {
    const u = useUnicorn();

    const removeBtns = el.querySelectorAll<HTMLButtonElement>('[data-remove-btn]');
    const insertBtns = el.querySelectorAll<HTMLButtonElement>('[data-insert-btn]');

    let sortable = options.sortable;

    if (sortable) {
      const sortableOptions = {
        sort: true,
        handle: '.c-handle',
      };

      import('sortablejs').then(({ default: Sortable }) => {
        module(
          el.querySelector('table tbody')!,
          'attachment.sortable',
          (ele) => new Sortable(ele as HTMLElement, sortableOptions)
        );
      });
    }

    // insert to editor
    insertBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        let a = document.createElement('a');
        const currentTarget = e.currentTarget as HTMLElement;

        const href = currentTarget?.dataset.href;
        const fileName = currentTarget?.dataset.filename;

        a.setAttribute('target', '_blank');

        if (href) {
          a.setAttribute('href', href);

        }

        if (fileName) {
          a.innerText = fileName;
        }

        useTinymce(btn.dataset.insertBtn || '#input-item-fulltext')
          .then((tinymce) => {
            tinymce.insert(a.outerHTML);
          });
      });
    });

    // remove file
    removeBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        const currentTarget = e.currentTarget as HTMLElement;

        let tr = currentTarget?.closest('tr');

        if (tr) {
          tr?.querySelector('[data-remove]')?.removeAttribute('disabled');

          fadeOut(tr);
        }
      });
    });
  }
}

async function init() {
  injectCssToDocument(document, css);

  useUniDirective<HTMLElement>(
    'attachment-list',
    {
      mounted(el, { value }) {
        const options = JSON.parse(value)

        module(el, 'attachment', (el) => new AttachmentHandler(el, options))
      }
    }
  );
}

export const ready = init();

export interface AttachmentModule {
  AttachmentHandler: typeof AttachmentHandler;
  ready: typeof ready;
}
