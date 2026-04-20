import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './ammap-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'ammap-section',
  templateUrl: './ammap-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class AmMapSectionComponent {
  name = 'AmMap';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
