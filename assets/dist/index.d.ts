declare class AttachmentHandler {
    protected el: HTMLElement;
    protected options: Options;
    constructor(el: HTMLElement, options: Options);
    init(el: HTMLElement, options: Options): void;
}

declare interface AttachmentModule {
    AttachmentHandler: typeof AttachmentHandler;
    ready: typeof ready;
}

declare interface Options {
    sortable?: boolean;
}

declare const ready: Promise<void>;

export declare function useAttachment(): Promise<AttachmentModule>;

export { }
