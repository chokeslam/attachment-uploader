import { AttachmentModule } from '~attachment/attachment';

export function useAttachment(): Promise<AttachmentModule> {
  return import('~attachment/attachment');
}
