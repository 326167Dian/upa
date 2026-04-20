import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './form-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'form-section',
  templateUrl: './form-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class FormSectionComponent {
  name = 'Form';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
