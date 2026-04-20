import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './apex-chart-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'apex-chart-section',
  templateUrl: './apex-chart-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class ApexChartSectionComponent {
  name = 'ApexChart';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
