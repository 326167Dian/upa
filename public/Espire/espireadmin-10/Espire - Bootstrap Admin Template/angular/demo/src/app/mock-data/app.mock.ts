
import { API_ENDPOINT } from '@app/configs/app.config';
import { Server } from 'miragejs';
import { notificationData } from './data/notification';
import { uploadResponseData } from './data/upload';
import { mailData } from './data/mail';
import { chatData } from './data/chat';
import { tableCompanyData, tableTreeData, tableRowData } from './data/table';
import { usersData } from './data/users';
import { dashboardData } from './data/dasboard';

const NOTIFICATION = '/notification';
const UPLOAD = '/upload';
const TABLE_TREE = '/table/tree';
const TABLE_COMPANY = '/table/company';
const TABLE_ROW = '/table/row';
const USERS = '/users';
const MAIL = '/mail'
const MAIL_MARK = '/mail/mark'
const MAIL_DETAIL = '/mail/detail'
const CHAT = '/chat'
const CHAT_ID = '/chat/:id'
const CHAT_CONVERSATION = '/chat/conversation'
const DASHBOARD_MONTHLY_REVENUE = '/dashboard/monthly-revenue'
const DASHBOARD_REGION_DATA = '/dashboard/region-data'
const DASHBOARD_OVERVIEW_DATA = '/dashboard/overview'
const DASHBOARD_RECENT_TRANSACTION = '/dashboard/recent-transaction'
const DASHBOARD_RECENT_RATING = '/dashboard/recent-rating'
const DASHBOARD_DEVICE = '/dashboard/device'
const DASHBOARD_COUNTRIES = '/dashboard/countries'

export default () => {
    new Server({
		seeds(server) {
			server.db.loadData({
				notificationData,
				uploadResponseData,
				tableCompanyData,
				tableTreeData,
				tableRowData,
				usersData,
				mailData,
				chatData,
				dashboardData
			});
		},
      routes() {
			this.namespace = API_ENDPOINT;

			this.get(NOTIFICATION, schema => schema.db.notificationData);

			this.get(TABLE_COMPANY, schema => schema.db.tableCompanyData);

			this.get(TABLE_TREE, schema => schema.db.tableTreeData);

			this.get(TABLE_ROW, schema => schema.db.tableRowData);

			this.get(USERS, schema => schema.db.usersData);

			this.get(CHAT, schema => schema.db.chatData);

			this.get(CHAT_ID, (schema, request) => {
				const id = request.params.id
				const data = schema.db.chatData.find(id)
				return data
			});

			this.post(CHAT_CONVERSATION, (schema, request) => {
				let requestBody = JSON.parse(request.requestBody)
				console.log('aytrw', requestBody)
				const data = schema.db.chatData.update(parseInt(requestBody.id), {msg: requestBody.msg})
				console.log('data', data)
				return data
			});
			
			this.get(MAIL, (schema, request) => {
				let cat = request.queryParams.cat
				const query = new Object();
				query[cat] = 0
				const data = schema.db.mailData.where(query)
				return data
			})

			this.del(MAIL, (schema, request) => {
				let body = JSON.parse(request.requestBody)
				let ids = body.ids
				ids.forEach(id => {
					schema.db.mailData.remove(id)
				});
				const data = schema.db.mailData
				return data
			})

			this.get(MAIL_DETAIL, (schema, request) => {
				let id = request.queryParams.id
				const data = schema.db.mailData.find(id)
				return data
			})

			this.post(MAIL_MARK, (schema, request) => {
				let attrs = JSON.parse(request.requestBody)
				const data = schema.db.mailData.update(parseInt(attrs.id), {marked: attrs.mark})
				return data
			})

			this.post(UPLOAD, (schema) => {
				return schema.db.uploadResponseData;
			});

			this.get(DASHBOARD_MONTHLY_REVENUE, schema => {
				const data = schema.db.dashboardData[0]
				return data.monthlyRevenue
			});
			
			this.get(DASHBOARD_REGION_DATA, schema => {
				const data = schema.db.dashboardData[0]
				return data.regionData
			});

			this.get(DASHBOARD_OVERVIEW_DATA, schema => {
				const data = schema.db.dashboardData[0]
				return data.overViewData
			});

			this.get(DASHBOARD_RECENT_TRANSACTION, schema => {
				const data = schema.db.dashboardData[0]
				return data.recentTransactionData
			});

			this.get(DASHBOARD_RECENT_RATING, schema => {
				const data = schema.db.dashboardData[0]
				return data.recentRatingData
			});

			this.get(DASHBOARD_DEVICE, schema => {
				const data = schema.db.dashboardData[0]
				return data.deviceStatisticData
			});

			this.get(DASHBOARD_COUNTRIES, schema => {
				const data = schema.db.dashboardData[0]
				return data.countriesData
			});
		}
    });
};
