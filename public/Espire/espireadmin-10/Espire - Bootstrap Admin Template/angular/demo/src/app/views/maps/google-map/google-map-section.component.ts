import { ChangeDetectionStrategy, Component } from '@angular/core';

import { demoComponentContent } from './google-map-section.list';
import { ContentSection } from '@app/shared/components/docs/models/content-section.model';

@Component({
  selector: 'google-map-section',
  templateUrl: './google-map-section.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class GoogleMapSectionComponent {
  name = 'GoogleMap';
  src = '';
  componentContent: ContentSection[] = demoComponentContent;
}
