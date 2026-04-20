import { DemoApexBasicComponent } from './demos/basic/basic';
import { DemoApexDashLineComponent } from './demos/dash-line/dash-line';
import { DemoApexBasicAreaComponent } from './demos/basic-area/basic-area';
import { DemoApexSplineAreaComponent } from './demos/spline-area/spline-area';
import { DemoApexBasicColumnComponent } from './demos/basic-column/basic-column';
import { DemoApexStackColumnComponent } from './demos/stack-column/stack-column';
import { DemoApexBasicBarComponent } from './demos/basic-bar/basic-bar';
import { DemoApexGroupBarComponent } from './demos/group-bar/group-bar';
import { DemoApexPieComponent } from './demos/pie/pie';
import { DemoApexDonutComponent } from './demos/donut/donut';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic',
        anchor: 'basic',
        description: ``,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoApexBasicComponent
      },
      {
        title: 'Dash Line',
        anchor: 'dash-line',
        description: ``,
        component: require('!!raw-loader!./demos/dash-line/dash-line'),
        html: require('!!raw-loader!./demos/dash-line/dash-line.html'),
        outlet: DemoApexDashLineComponent
      },
      {
        title: 'Basic Area',
        anchor: 'basic-area',
        description: ``,
        component: require('!!raw-loader!./demos/basic-area/basic-area'),
        html: require('!!raw-loader!./demos/basic-area/basic-area.html'),
        svc: require('!!raw-loader!./demos/basic-area/data'),
        outlet: DemoApexBasicAreaComponent
      },
      {
        title: 'Spline Area',
        anchor: 'spline-area',
        description: ``,
        component: require('!!raw-loader!./demos/spline-area/spline-area'),
        html: require('!!raw-loader!./demos/spline-area/spline-area.html'),
        outlet: DemoApexSplineAreaComponent
      },
      {
        title: 'Basic Column',
        anchor: 'basic-column',
        description: ``,
        component: require('!!raw-loader!./demos/basic-column/basic-column'),
        html: require('!!raw-loader!./demos/basic-column/basic-column.html'),
        outlet: DemoApexBasicColumnComponent
      },
      {
        title: 'Stack Column',
        anchor: 'stack-column',
        description: ``,
        component: require('!!raw-loader!./demos/stack-column/stack-column'),
        html: require('!!raw-loader!./demos/stack-column/stack-column.html'),
        outlet: DemoApexStackColumnComponent
      },
      {
        title: 'Basic Bar',
        anchor: 'basic-bar',
        description: ``,
        component: require('!!raw-loader!./demos/basic-bar/basic-bar'),
        html: require('!!raw-loader!./demos/basic-bar/basic-bar.html'),
        outlet: DemoApexBasicBarComponent
      },
      {
        title: 'Grouped Bar',
        anchor: 'group-bar',
        description: ``,
        component: require('!!raw-loader!./demos/group-bar/group-bar'),
        html: require('!!raw-loader!./demos/group-bar/group-bar.html'),
        outlet: DemoApexGroupBarComponent
      },
      {
        title: 'Simple pie',
        anchor: 'pie',
        description: ``,
        component: require('!!raw-loader!./demos/pie/pie'),
        html: require('!!raw-loader!./demos/pie/pie.html'),
        outlet: DemoApexPieComponent
      },
      {
        title: 'Simple donut',
        anchor: 'donut',
        description: ``,
        component: require('!!raw-loader!./demos/donut/donut'),
        html: require('!!raw-loader!./demos/donut/donut.html'),
        outlet: DemoApexDonutComponent
      }
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'ChartComponent',
        anchor: 'ChartComponent',
        outlet: NgApiDocComponent
      }
    ]
  }
];
