import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './select-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'select-section',
  templateUrl: './select-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class SelectSectionComponent {
  name = 'Select';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
