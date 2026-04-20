import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './checkbox-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'checkbox-section',
  templateUrl: './checkbox-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class CheckboxSectionComponent {
  name = 'Checkbox';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
