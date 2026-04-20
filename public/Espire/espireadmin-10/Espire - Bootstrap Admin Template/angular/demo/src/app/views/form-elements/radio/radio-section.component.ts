import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './radio-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'radio-section',
  templateUrl: './radio-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class RadioSectionComponent {
  name = 'Radio';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
