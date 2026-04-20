import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './data-table-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'data-table-section',
  templateUrl: './data-table-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class DataTableSectionComponent {
  name = 'DataTable';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
