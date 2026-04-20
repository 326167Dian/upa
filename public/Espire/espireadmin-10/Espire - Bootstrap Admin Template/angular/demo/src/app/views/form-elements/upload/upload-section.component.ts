import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './upload-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'upload-section',
  templateUrl: './upload-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class UploadSectionComponent {
  name = 'Upload';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
