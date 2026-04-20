import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './switch-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'switch-section',
  templateUrl: './switch-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class SwitchSectionComponent {
  name = 'Switch';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
