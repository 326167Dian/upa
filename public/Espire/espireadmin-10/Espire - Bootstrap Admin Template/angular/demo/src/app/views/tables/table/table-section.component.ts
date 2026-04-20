import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './table-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'table-section',
  templateUrl: './table-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class TableSectionComponent {
  name = 'Table';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
