import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './input-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'input-section',
  templateUrl: './input-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class InputSectionComponent {
  name = 'Input';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
