declare class AttachmentHandler {
    protected el: HTMLElement;
    protected options: AttachmentOptions;
    constructor(el: HTMLElement, options: AttachmentOptions);
    init(el: HTMLElement, options: AttachmentOptions): void;
}

declare interface AttachmentModule {
    AttachmentHandler: typeof AttachmentHandler;
    ready: typeof ready;
}

declare interface AttachmentOptions {
    sortable?: boolean;
}

declare const ready: Promise<void>;

export declare function useAttachment(): Promise<AttachmentModule>;

export { }
