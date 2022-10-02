<template>
  <div>
    <div class="table-2">
      <table width="100%">
        <thead>
          <tr>
            <td width="19.28%">公司主体信息</td>
            <td width="72.13%%">注册信息</td>
            <td width="">更多信息</td>
          </tr>
        </thead>
      </table>
    </div>
    <div class="company-box" v-for="(item) in companyInfo" :key="item.id">
      <table width="100%">
        <tbody>
          <tr>
            <td width="19.28%" valign="top">
              <div class="c-content">
                <div class="c-tit clearFl">
                  <span class="c-num fl">#{{ item.number }}</span>
                  <span class="fl" style="color: #333;">{{ item.company_name ? item.company_name : publicJS.blankData }}</span>
                  <div class="p-tip-b fl">
                    <div class="iconfont iconshiyi"></div>
                    <div class="p-tip-1 left-b">
                      <div class="arrow iconfont iconsanjiao"></div>
                      <div class="tip-box pd20" style="width: 200px;">
                        {{ item.profile ? item.profile : publicJS.blankData }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="c-list">{{ item.company_simple_name ? item.company_simple_name : publicJS.blankData }}</div>
                <div class="c-list">{{ item.company_english_name ? item.company_english_name : publicJS.blankData  }}</div>
                <div class="c-list clearFl">
                  <div class="p-label red1 fl" v-if="item.type === 1">母公司</div>
                  <div class="p-label yellow1 fl" v-else-if="item.type === 2">子公司</div>
                  <div class="p-label yellow1 fl" v-else-if="item.type === 3">分公司</div>
                </div>
                <div class="c-status">
                  <div v-if="item.status === 1"><i class="iconfont icondaishenhe fl" style="color: #4ed0ae;font-size: 14px;margin-right: 4px"></i>运营中</div>
                  <div v-else-if="item.status === 0"><i class="iconfont icondaishenhe fl" style="color: #ff4d50;font-size: 14px;margin-right: 4px"></i>关闭中</div>
                </div>
              </div>
            </td>
            <td width="72.13%" valign="top">
              <div class="c-content" v-if="!item.editStatus">
                <div class="c-list clearFl">
                  <div class="fl p-ellipsis pdR20" style="width:26.92%">
                    <span style="color: #bbb;">公司名称：</span><span :title="item.address.name ? item.address.name : publicJS.blankData">{{ item.address.name ? item.address.name : publicJS.blankData }}</span>
                  </div>
                  <div class="fl p-ellipsis pdR20" style="width:26.92%">
                    <span style="color: #bbb;">外语名称：</span><span :title="item.address.en_name ? item.address.en_name : publicJS.blankData">{{ item.address.en_name ? item.address.en_name : publicJS.blankData }}</span>
                  </div>
                  <div class="fl p-ellipsis pdR20" style="width:15.38%">
                    <span style="color: #bbb;">联系人：</span><span :title="item.contacts ? item.contacts : publicJS.blankData">{{ item.contacts ? item.contacts : publicJS.blankData }}</span>
                  </div>
                  <div class="fl p-ellipsis pdR20" style="width:15.38%">
                    <span style="color: #bbb;">附件：</span>
                    <a-popover v-if="item.media.length > 0" placement="bottomLeft"
                       :getPopupContainer="triggerNode => triggerNode.parentNode"
                       arrowPointAtCenter>
                      <template slot="content">
                        <div class="download-list">
                          <p>附件</p>
                          <downPrd :media="item.media"></downPrd>
                        </div>
                      </template>
                      <span class="icon iconfont iconliebiaofujian"></span>
                    </a-popover>
                    <span v-else>{{ publicJS.blankData }}</span>
                  </div>
                </div>
                <div class="c-list" style="padding-left: 92px;">
                  <span class="c-little-tit">注册地址(中文)：</span>
                  <span>{{ item.address.cnAddress ? item.address.cnAddress : publicJS.blankData }}</span>
                  <span style="margin-left: 12px;" v-if="item.address.tel">电话：{{ item.address.tel ? item.address.tel : publicJS.blankData }}</span>
                </div>
                <div class="c-list" style="padding-left: 92px;">
                  <span class="c-little-tit">注册地址(外语)：</span>
                  <span>{{item.address.enAddress ? item.address.enAddress : publicJS.blankData}}</span>
                  <span style="margin-left: 12px;" v-if="item.address.tel">Tel: {{ item.address.en_tel ? item.address.en_tel : publicJS.blankData }}</span>
                </div>
                <div class="c-list p-ellipsis" :style="{ 'margin-bottom': (canDo('company.registry.update') ? '' : '0'), 'padding-left': '84px' }">
                  <span class="c-little-tit">纳税人识别号：</span>
                  <span v-for="(info) in item.company_tax_info" :key="info.id">
                    {{ (info.country ? '(' + info.country + ')' : '')  + info.tax_number + '；' }}
                  </span>
                  <span v-if="item.company_tax_info.length === 0">{{ publicJS.blankData }}</span>
                  <!--<span class="more-btn">更多</span> -->
                </div>
                <div v-if="canDo('company.registry.update')" style="padding-top: 2px;">
                  <span class="edit-btn" @click="editRegister(item)"><i class="iconfont iconbianji"></i>编辑</span>
                </div>
              </div>
              <div class="c-content-edit" v-else-if="item.editStatus">
                <ul class="clearFl float type2" style="margin-right: -40px;">
                  <li class="pdR40 marginB20">
                    <p class="p-title must">公司名称：</p>
                    <a-input placeholder="请输入中文注册名称" :defaultValue="item.address.name" @blur="e => changeValue(e.target.value, item, 'name')" />
                  </li>
                  <li class="pdR40 marginB20">
                    <p class="p-title must">外语名称：</p>
                    <a-input placeholder="Foreign Registered name" :defaultValue="item.address.en_name" @blur="e => changeValue(e.target.value, item, 'en_name')" />
                  </li>
                  <li class="pdR40 marginB20">
                    <p class="p-title must">注册地址(中文)：</p>
                    <div class="clearFl marginB10">
                      <div class="fl pdR10" style="width: 20%">
                        <a-select
                          show-search
                          placeholder="请选择"
                          option-filter-prop="children"
                          :style="{width: '100%', color: (item.address.country ? '': '#bbb')}"
                          :filter-option="filterOption"
                          :defaultValue="item.address.country ? item.address.country : '请选择国家'"
                          :getPopupContainer="triggerNode => triggerNode.parentNode"
                          @change="changeValue($event, item, 'country')"
                        >
                          <a-select-option v-for="(list) in countrys" :key="list.id" :value="list.name">
                            {{ list.name }}
                          </a-select-option>
                        </a-select>
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="省" :defaultValue="item.address.province" @blur="e => changeValue(e.target.value, item, 'province')" />
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="市" :defaultValue="item.address.city" @blur="e => changeValue(e.target.value, item, 'city')" />
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="区" :defaultValue="item.address.area" @blur="e => changeValue(e.target.value, item, 'area')" />
                      </div>
                      <div class="fl" style="width: 20%">
                        <a-input placeholder="请输入电话" :defaultValue="item.address.tel" @blur="e => changeValue(e.target.value, item, 'tel')" />
                      </div>
                    </div>
                    <div>
                      <a-textarea placeholder="请输入详细地址" :defaultValue="item.address.address === 'null' || !item.address.address  ? '' : item.address.address" style="height: 80px;" @blur="e => changeValue(e.target.value, item, 'address')" />
                    </div>
                  </li>
                  <li class="pdR40 marginB20">
                    <p class="p-title must">注册地址(外语)：</p>
                    <div class="clearFl marginB10">
                      <div class="fl pdR10" style="width: 20%">
                        <a-select
                          show-search
                          placeholder="Country"
                          option-filter-prop="children"
                          :style="{width: '100%', color: (item.address.en_country ? '': '#bbb')}"
                          :filter-option="filterOption"
                          :defaultValue="item.address.en_country ? item.address.en_country: 'Country'"
                          :getPopupContainer="triggerNode => triggerNode.parentNode"
                          @change="changeValue($event, item, 'en_country')"
                        >
                          <a-select-option v-for="(list) in countrys" :key="list.id" :value="list.en_name">
                            {{ list.en_name }}
                          </a-select-option>
                        </a-select>
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="Province" :defaultValue="item.address.en_province" @blur="e => changeValue(e.target.value, item, 'en_province')" />
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="City" :defaultValue="item.address.en_city" @blur="e => changeValue(e.target.value, item, 'en_city')" />
                      </div>
                      <div class="fl pdR10" style="width: 20%">
                        <a-input placeholder="Region" :defaultValue="item.address.en_area" @blur="e => changeValue(e.target.value, item, 'en_area')" />
                      </div>
                      <div class="fl" style="width: 20%">
                        <a-input placeholder="Telephone" :defaultValue="item.address.en_tel" @blur="e => changeValue(e.target.value, item, 'en_tel')" />
                      </div>
                    </div>
                    <div>
                      <a-textarea placeholder="Address" :defaultValue="item.address.en_address === 'null' || !item.address.en_address  ? '' : item.address.en_address" style="height: 80px;" @blur="e => changeValue(e.target.value, item, 'en_address')" />
                    </div>
                  </li>
                  <li class="pdR40 marginB20">
                    <p class="p-title">纳税人识别号：<a class="add-btn" @click="addIdentifier(item)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                    <div>
                      <div class="identifier-box clearFl" v-for="(identifier) in item.company_tax_info" :key="identifier.id">
                        <div class="fl pdR10" style="width: 20%">
                          <a-select
                            show-search
                            placeholder="Country"
                            option-filter-prop="children"
                            :style="{width: '100%', color: (identifier.country ? '': '#bbb')}"
                            :filter-option="filterOption"
                            :defaultValue="identifier.country ? identifier.country : 'Country'"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            @change="changeIdentifierValue($event, identifier, 'country')"
                          >
                            <a-select-option v-for="(list) in countrys" :key="list.id" :value="list.name">
                              {{ list.name }}
                            </a-select-option>
                          </a-select>
                        </div>
                        <div class="fl" style="width: 75.68%;">
                          <a-input placeholder="请输入税号" :defaultValue="identifier.tax_number" @blur="e => changeIdentifierValue(e.target.value, identifier, 'tax_number')" />
                        </div>
                        <i class="iconfont iconshanchu1" @click="deleteIdentifier(identifier.id, item)"></i>
                      </div>
                    </div>
                    <div>
                      <div class="identifier-box clearFl" v-for="(identifier) in item.new_tax" :key="identifier.id">
                        <div class="fl pdR10" style="width: 20%">
                          <a-select
                            show-search
                            placeholder="Country"
                            option-filter-prop="children"
                            :style="{width: '100%', color: (identifier.country ? '': '#bbb')}"
                            :filter-option="filterOption"
                            :defaultValue="identifier.country ? identifier.country : 'Country'"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            @change="changeIdentifierValue($event, identifier, 'country')"
                          >
                            <a-select-option v-for="(list) in countrys" :key="list.id" :value="list.name">
                              {{ list.name }}
                            </a-select-option>
                          </a-select>
                        </div>
                        <div class="fl" style="width: 75.68%;">
                          <a-input placeholder="请输入税号" :defaultValue="identifier.tax_number" @blur="e => changeIdentifierValue(e.target.value, identifier, 'tax_number')" />
                        </div>
                        <i class="iconfont iconshanchu1" @click="deleteIdentifier(identifier.id, item, 1)"></i>
                      </div>
                    </div>
                    <div class="no-data" v-if="item.company_tax_info.length === 0 && item.new_tax.length === 0">暂无信息~</div>
                  </li>
                  <li class="pdR40 marginB20">
                    <p class="p-title">联系人：</p>
                    <a-input placeholder="请输入联系人名称" :defaultValue="item.contacts === 'undefined' ? '' : (item.contacts === 'null' ? '' :item.contacts)" @blur="e => changeValue(e.target.value, item, 'contacts')" />
                  </li>
                </ul>
                <div style="padding-bottom: 10px;">
                  <p class="p-title">附件：<a class="add-btn" @click="addFile(item)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                  <div class="p-file-box clearFl" v-for="(list, index) in item.media" :key="list.id">
                    <div class="file-name">
                      <a-input :value="list.name" placeholder="请选择附件" disabled />
                    </div>
                    <div class="file-btn">
                      <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, item, list)">
                        <a-button size="small">选择文件</a-button>
                      </a-upload>
                    </div>
                    <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, item)"></div>
                  </div>
                  <div class="no-data" v-if="item.media.length === 0">暂无信息~</div>
                </div>
                <div class="clearFl">
                  <div class="fl save-btn" @click="saveRegister(item)">保存</div>
                  <div class="fl cancel-btn" @click="cancelRegister(item)">取消</div>
                </div>
              </div>
            </td>
            <td width="" valign="top">
              <div class="c-content">
                <div class="c-list">
                  <a-checkbox @change="changePart($event, 1, item)" :checked="item.radioValue === 1 ? true : false" :disabled="item.editStatus || (canEditID === item.id && !canEdit )">
                    办公地址
                  </a-checkbox>
                </div>
                <div class="c-list">
                  <a-checkbox @change="changePart($event, 2, item)" :checked="item.radioValue === 2 ? true : false" :disabled="item.editStatus || (canEditID === item.id && !canEdit )">
                    仓储地址
                  </a-checkbox>
                </div>
                <div>
                  <a-checkbox @change="changePart($event, 3, item)" :checked="item.radioValue === 3 ? true : false" :disabled="item.editStatus || (canEditID === item.id && !canEdit )">
                    账户信息
                  </a-checkbox>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="companyInfo-more" width="100%" v-if="item.radioValue === 1">
        <tbody>
          <tr>
            <td width="19.28%" align="center" style="padding: 18px 40px 30px 0;">
              <div class="left-part">
                <div class="marginB9 officeAddress"></div>
                <div :class="canDo('company.office.update') ? 'marginB9' : ''">办公地址信息</div>
                <div v-if="canDo('company.office.update')" class="add-info" :class="canEdit ? '' : 'disabled'" @click="addOffice(item)"></div>
              </div>
            </td>
            <td valign="top" style="padding: 18px 20px 30px;">
              <div class="right-part">
                <ul>
                  <li :class="item.newOffice.length > 0 ? 'not-last' : ''" v-for="(office, i) in item.office" :key="office.id">
                    <div class="clearFl" v-if="office.editStatus">
                      <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                        <div class="part-tit clearFl">
                          <b>#{{ i + 1 }}</b>
                        </div>
                        <ul class="float type2 clearFl" style="margin-right: -40px;">
                          <li class="pdR40 marginB20">
                            <p class="p-title must">中文名称：</p>
                            <a-input placeholder="请输入中文公司名称" :defaultValue="office.name" @blur="e => changeOfficeValue(e.target.value, office, 'name')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">外语名称：</p>
                            <a-input placeholder="Foreign company name" :defaultValue="office.en_name" @blur="e => changeOfficeValue(e.target.value, office, 'en_name')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">地址(中文)：</p>
                            <div class="clearFl marginB10">
                              <div class="fl pdR10" style="width: 20%">
                                <a-select
                                  show-search
                                  placeholder="请选择"
                                  option-filter-prop="children"
                                  :style="{width: '100%', color: (office.country ? '': '#bbb')}"
                                  :filter-option="filterOption"
                                  :defaultValue="office.country ? office.country : '请选择国家'"
                                  :getPopupContainer="triggerNode => triggerNode.parentNode"
                                  @change="changeOfficeValue($event, office, 'country')"
                                >
                                  <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.name">
                                    {{ child.name }}
                                  </a-select-option>
                                </a-select>
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="省" :defaultValue="office.province" @blur="e => changeOfficeValue(e.target.value, office, 'province')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="市" :defaultValue="office.city" @blur="e => changeOfficeValue(e.target.value, office, 'city')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="区" :defaultValue="office.area" @blur="e => changeOfficeValue(e.target.value, office, 'area')" />
                              </div>
                              <div class="fl" style="width: 20%">
                                <a-input placeholder="请输入邮编" :defaultValue="office.postcode" @blur="e => changeOfficeValue(e.target.value, office, 'postcode')" />
                              </div>
                            </div>
                            <div>
                              <a-textarea placeholder="请输入详细地址" :defaultValue="office.address === 'null' || !office.address  ? '' : office.address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'address')" />
                            </div>
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">Address(外语)：</p>
                            <div class="clearFl marginB10">
                              <div class="fl pdR10" style="width: 20%">
                                <a-select
                                  show-search
                                  placeholder="Country"
                                  option-filter-prop="children"
                                  :style="{width: '100%', color: (office.en_country ? '': '#bbb')}"
                                  :filter-option="filterOption"
                                  :defaultValue="office.en_country ? office.en_country: 'Country'"
                                  :getPopupContainer="triggerNode => triggerNode.parentNode"
                                  @change="changeOfficeValue($event, office, 'en_country')"
                                >
                                  <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.en_name">
                                    {{ child.en_name }}
                                  </a-select-option>
                                </a-select>
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="State" :defaultValue="office.en_province" @blur="e => changeOfficeValue(e.target.value, office, 'en_province')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="Province" :defaultValue="office.en_city" @blur="e => changeOfficeValue(e.target.value, office, 'en_city')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="Region" :defaultValue="office.en_area" @blur="e => changeOfficeValue(e.target.value, office, 'en_area')" />
                              </div>
                              <div class="fl" style="width: 20%">
                                <a-input placeholder="Zip code" :defaultValue="office.en_postcode" @blur="e => changeOfficeValue(e.target.value, office, 'en_postcode')" />
                              </div>
                            </div>
                            <div>
                              <a-textarea placeholder="Address" :defaultValue="office.en_address === 'null' || !office.en_address  ? '' : office.en_address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'en_address')" />
                            </div>
                          </li>
                          <li class="pdR40 marginB10">
                            <p class="p-title">联系方式(中文)：<a class="add-btn" @click="addOfficeContacts(office, 1)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in office.contacts" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 1)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in office.contacts_new" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 1, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="office.contacts.length === 0 && office.contacts_new.length === 0">暂无信息~</div>
                          </li>
                          <li class="pdR40 marginB10">
                            <p class="p-title">Contact(外语)：<a class="add-btn" @click="addOfficeContacts(office, 2)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in office.en_contacts" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 2)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in office.en_contacts_new" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 2, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="office.en_contacts.length === 0 && office.en_contacts_new.length === 0">暂无信息~</div>
                          </li>
                        </ul>
                        <div class="marginB20">
                          <p class="p-title">说明：</p>
                          <a-textarea placeholder="请输入说明" :defaultValue="office.comment === 'null' || !office.comment  ? '' : office.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'comment')" />
                        </div>
                        <div style="padding-bottom: 10px;">
                          <p class="p-title">附件：<a class="add-btn" @click="addFile(office)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="p-file-box clearFl" v-for="(list, index) in office.media" :key="list.id">
                            <div class="file-name">
                              <a-input :value="list.name" placeholder="请选择附件" disabled />
                            </div>
                            <div class="file-btn">
                              <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, office, list)">
                                <a-button size="small">选择文件</a-button>
                              </a-upload>
                            </div>
                            <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, office)"></div>
                          </div>
                          <div class="no-data" v-if="office.media.length === 0">暂无信息~</div>
                        </div>
                        <div class="clearFl">
                          <div class="fl save-btn" @click="saveOffice(item, office.id)">保存</div>
                          <div class="fl cancel-btn" @click="cancelOffice(item, office.id)">取消</div>
                        </div>
                      </div>
                      <div class="fr" style="width: 7.8864%">
                        <div v-if="canDo('company.office.status.update')" style="padding-left: 20px;">
                          <p class="p-title">使用/注销：</p>
                          <a-switch class="switch-btn" :checked="(office.status === 1 ? true : false)" @change="ifShow($event, office, 'office', item.id)" />
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="part-tit clearFl">
                        <b>#{{ i + 1 }}</b>
                        <div class="fl" :class="canDo('company.office.statusLogs') ? 'pointer' : ''" v-if="office.status === 1" @click="showStatusLog(office.id, 'office')"><i class="iconfont icondaishenhe fl" style="color: #4ed0ae;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>使用中</div>
                        <div class="fl" :class="canDo('company.office.statusLogs') ? 'pointer' : ''" v-else-if="office.status === 0" @click="showStatusLog(office.id, 'office')"><i class="iconfont icondaishenhe fl" style="color: #ff4d50;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>已注销</div>
                      </div>
                      <div class="c-list clearFl">
                        <div class="fl pdR20" style="width:26.92%">
                          <span class="fl" style="color: #bbb;">中文名称：</span>
                          <span :title="office.name ? office.name : publicJS.blankData" class="fl p-ellipsis" style="max-width: calc(100% - 78px);">{{ office.name ? office.name : publicJS.blankData }}</span>
                          <div class="p-tip-b fl">
                            <div class="iconfont iconshiyi lineH14"></div>
                            <div class="p-tip-1 left-b">
                              <div class="arrow iconfont iconsanjiao"></div>
                              <div class="tip-box pd20" style="width: 200px;">
                                {{ office.comment ? office.comment : publicJS.blankData }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="fl p-ellipsis pdR20" style="width:26.92%">
                          <span style="color: #bbb;">外语名称：</span>
                          <span :title="office.en_name ? office.en_name : publicJS.blankData">{{ office.en_name ? office.en_name : publicJS.blankData }}</span>
                        </div>
                        <div class="fl p-ellipsis pdR20" style="width:15.38%">
                          <span style="color: #bbb;">附件：</span>
                          <a-popover v-if="office.media.length > 0" placement="bottomLeft"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            arrowPointAtCenter>
                            <template slot="content">
                              <div class="download-list">
                                <p>附件</p>
                                <downPrd :media="office.media"></downPrd>
                              </div>
                            </template>
                            <span class="icon iconfont iconliebiaofujian"></span>
                          </a-popover>
                          <span v-else>{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div class="c-list">
                        <div class="mgB8 positionRe" style="padding-left: 68px;">
                          <span class="c-little-tit">地址(中文)：</span>
                          <span>{{ office.cnAddress ? office.cnAddress : publicJS.blankData }}</span>
                          <span style="margin-left: 12px;">邮编：{{ office.postcode ? office.postcode : publicJS.blankData }}</span>
                        </div>
                        <div class="positionRe" style="padding-left: 48px;">
                          <span class="c-little-tit">联系人：</span>
                          <span style="margin-right: 12px;" v-for="(contact) in office.contacts" :key="contact.id">
                            {{ contact.contacts + '/' + contact.tel + '；' }}
                          </span>
                          <span v-if="office.contacts.length === 0">{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div class="c-list" :style="{ 'margin-bottom': (canDo('company.office.update') ? '' : '0') }">
                        <div class="mgB8 positionRe" style="padding-left: 68px;">
                          <span class="c-little-tit">地址(外语)：</span>
                          <span>{{ office.enAddress ? office.enAddress : publicJS.blankData }}</span>
                          <span style="margin-left: 12px;">Postcode: {{ office.en_postcode ? office.en_postcode : publicJS.blankData }}</span>
                        </div>
                        <div class="positionRe" style="padding-left: 48px;">
                          <span class="c-little-tit">联系人：</span>
                          <span style="margin-right: 12px;" v-for="(contact) in office.en_contacts" :key="contact.id">
                            {{ contact.contacts + '/' + contact.tel + '；' }}
                          </span>
                          <span v-if="office.en_contacts.length === 0">{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div v-if="canDo('company.office.update')" style="padding-top: 2px;">
                        <span class="edit-btn" @click="editOffice(office, item.id)"><i class="iconfont iconbianji"></i>编辑</span>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul>
                  <li class="clearFl" v-for="(office) in item.newOffice" :key="office.id">
                    <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                      <ul class="float type2 clearFl" style="margin-right: -40px;">
                        <li class="pdR40 marginB20">
                          <p class="p-title must">中文名称：</p>
                          <a-input placeholder="请输入中文公司名称" :defaultValue="office.name" @blur="e => changeOfficeValue(e.target.value, office, 'name')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">外语名称：</p>
                          <a-input placeholder="Foreign company name" :defaultValue="office.en_name" @blur="e => changeOfficeValue(e.target.value, office, 'en_name')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">地址(中文)：</p>
                          <div class="clearFl marginB10">
                            <div class="fl pdR10" style="width: 20%">
                              <a-select
                                show-search
                                placeholder="请选择"
                                option-filter-prop="children"
                                :style="{width: '100%', color: (office.country ? '': '#bbb')}"
                                :filter-option="filterOption"
                                :defaultValue="office.country ? office.country : '请选择国家'"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                @change="changeOfficeValue($event, office, 'country')"
                              >
                                <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.name">
                                  {{ child.name }}
                                </a-select-option>
                              </a-select>
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="省" :defaultValue="office.province" @blur="e => changeOfficeValue(e.target.value, office, 'province')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="市" :defaultValue="office.city" @blur="e => changeOfficeValue(e.target.value, office, 'city')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="区" :defaultValue="office.area" @blur="e => changeOfficeValue(e.target.value, office, 'area')" />
                            </div>
                            <div class="fl" style="width: 20%">
                              <a-input placeholder="请输入邮编" :defaultValue="office.postcode" @blur="e => changeOfficeValue(e.target.value, office, 'postcode')" />
                            </div>
                          </div>
                          <div>
                            <a-textarea placeholder="请输入详细地址" :defaultValue="office.address === 'null' || !office.address  ? '' : office.address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'address')" />
                          </div>
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">Address(外语)：</p>
                          <div class="clearFl marginB10">
                            <div class="fl pdR10" style="width: 20%">
                              <a-select
                                show-search
                                placeholder="Country"
                                option-filter-prop="children"
                                :style="{width: '100%', color: (office.en_country ? '': '#bbb')}"
                                :filter-option="filterOption"
                                :defaultValue="office.en_country ? office.en_country : 'Country'"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                @change="changeOfficeValue($event, office, 'en_country')"
                              >
                                <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.en_name">
                                  {{ child.en_name }}
                                </a-select-option>
                              </a-select>
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Province" :defaultValue="office.en_province" @blur="e => changeOfficeValue(e.target.value, office, 'en_province')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="City" :defaultValue="office.en_city" @blur="e => changeOfficeValue(e.target.value, office, 'en_city')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Region" :defaultValue="office.en_area" @blur="e => changeOfficeValue(e.target.value, office, 'en_area')" />
                            </div>
                            <div class="fl" style="width: 20%">
                              <a-input placeholder="Zip code" :defaultValue="office.en_postcode" @blur="e => changeOfficeValue(e.target.value, office, 'en_postcode')" />
                            </div>
                          </div>
                          <div>
                            <a-textarea placeholder="Address" :defaultValue="office.en_address === 'null' || !office.en_address  ? '' : office.en_address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'en_address')" />
                          </div>
                        </li>
                        <li class="pdR40 marginB10">
                          <p class="p-title">联系方式(中文)：<a class="add-btn" @click="addOfficeContacts(office, 1)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="identifier-box clearFl" v-for="(contact) in office.contacts_new" :key="contact.id">
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                            </div>
                            <div class="fl" style="width: 75.68%;">
                              <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                            </div>
                            <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 1, 1)"></i>
                          </div>
                          <div class="no-data" v-if="office.contacts_new.length === 0">暂无信息~</div>
                        </li>
                        <li class="pdR40 marginB10">
                          <p class="p-title">Contact(外语)：<a class="add-btn" @click="addOfficeContacts(office, 2)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="identifier-box clearFl" v-for="(contact) in office.en_contacts_new" :key="contact.id">
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                            </div>
                            <div class="fl" style="width: 75.68%;">
                              <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                            </div>
                            <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, office, 2, 1)"></i>
                          </div>
                          <div class="no-data" v-if="office.en_contacts_new.length === 0">暂无信息~</div>
                        </li>
                      </ul>
                      <div class="marginB20">
                        <p class="p-title">说明：</p>
                        <a-textarea placeholder="请输入说明" :defaultValue="office.comment === 'null' || !office.comment  ? '' : office.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, office, 'comment')" />
                      </div>
                      <div style="padding-bottom: 10px;">
                        <p class="p-title">附件：<a class="add-btn" @click="addFile(office)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                        <div class="p-file-box clearFl" v-for="(list, index) in office.media" :key="list.id">
                          <div class="file-name">
                            <a-input :value="list.name" placeholder="请选择附件" disabled />
                          </div>
                          <div class="file-btn">
                            <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, office, list)">
                              <a-button size="small">选择文件</a-button>
                            </a-upload>
                          </div>
                          <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, office)"></div>
                        </div>
                        <div class="no-data" v-if="office.media.length === 0">暂无信息~</div>
                      </div>
                      <div class="clearFl">
                        <div class="fl save-btn" @click="saveOffice(item, office.id, 1)">保存</div>
                        <div class="fl cancel-btn" @click="cancelOffice(item, office.id, 1)">取消</div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="companyInfo-more" width="100%" v-else-if="item.radioValue === 2">
        <tbody>
          <tr>
            <td width="19.28%" align="center" style="padding: 18px 40px 30px 0;">
              <div class="left-part">
                <div class="marginB9 warehouseAddress"></div>
                <div :class="canDo('company.warehouse.update') ? 'marginB9' : ''">仓储地址信息</div>
                <div v-if="canDo('company.warehouse.update')" class="add-info" :class="canEdit ? '' : 'disabled'" @click="addWarehouse(item)"></div>
              </div>
            </td>
            <td valign="top" style="padding: 18px 20px 30px;">
              <div class="right-part">
                <ul>
                  <li :class="item.new_warehouse.length > 0 ? 'not-last' : ''" v-for="(warehouse, i) in item.warehouse" :key="warehouse.id">
                    <div class="clearFl" v-if="warehouse.editStatus">
                      <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                        <div class="part-tit clearFl">
                          <b>#{{ i + 1 }}</b>
                        </div>
                        <ul class="float type2 clearFl" style="margin-right: -40px;">
                          <li class="pdR40 marginB20">
                            <p class="p-title must">中文名称：</p>
                            <a-input placeholder="请输入中文公司名称" :defaultValue="warehouse.name" @blur="e => changeOfficeValue(e.target.value, warehouse, 'name')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">外语名称：</p>
                            <a-input placeholder="Foreign company name" :defaultValue="warehouse.en_name" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_name')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">地址(中文)：</p>
                            <div class="clearFl marginB10">
                              <div class="fl pdR10" style="width: 20%">
                                <a-select
                                  show-search
                                  placeholder="请选择"
                                  option-filter-prop="children"
                                  :style="{width: '100%', color: (warehouse.country ? '': '#bbb')}"
                                  :filter-option="filterOption"
                                  :defaultValue="warehouse.country ? warehouse.country : '请选择国家'"
                                  :getPopupContainer="triggerNode => triggerNode.parentNode"
                                  @change="changeOfficeValue($event, warehouse, 'country')"
                                >
                                  <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.name">
                                    {{ child.name }}
                                  </a-select-option>
                                </a-select>
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="省" :defaultValue="warehouse.province" @blur="e => changeOfficeValue(e.target.value, warehouse, 'province')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="市" :defaultValue="warehouse.city" @blur="e => changeOfficeValue(e.target.value, warehouse, 'city')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="区" :defaultValue="warehouse.area" @blur="e => changeOfficeValue(e.target.value, warehouse, 'area')" />
                              </div>
                              <div class="fl" style="width: 20%">
                                <a-input placeholder="请输入邮编" :defaultValue="warehouse.postcode" @blur="e => changeOfficeValue(e.target.value, warehouse, 'postcode')" />
                              </div>
                            </div>
                            <div>
                              <a-textarea placeholder="请输入详细地址" :defaultValue="warehouse.address === 'null' || !warehouse.address  ? '' : warehouse.address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'address')" />
                            </div>
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">Address(外语)：</p>
                            <div class="clearFl marginB10">
                              <div class="fl pdR10" style="width: 20%">
                                <a-select
                                  show-search
                                  placeholder="Country"
                                  option-filter-prop="children"
                                  :style="{width: '100%', color: (warehouse.en_country ? '': '#bbb')}"
                                  :filter-option="filterOption"
                                  :defaultValue="warehouse.en_country ? warehouse.en_country : 'Country'"
                                  :getPopupContainer="triggerNode => triggerNode.parentNode"
                                  @change="changeOfficeValue($event, warehouse, 'en_country')"
                                >
                                  <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.en_name">
                                    {{ child.en_name }}
                                  </a-select-option>
                                </a-select>
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="Province" :defaultValue="warehouse.en_province" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_province')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="City" :defaultValue="warehouse.en_city" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_city')" />
                              </div>
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="Region" :defaultValue="warehouse.en_area" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_area')" />
                              </div>
                              <div class="fl" style="width: 20%">
                                <a-input placeholder="Zip code" :defaultValue="warehouse.en_postcode" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_postcode')" />
                              </div>
                            </div>
                            <div>
                              <a-textarea placeholder="Address" :defaultValue="warehouse.en_address === 'null' || !warehouse.en_address  ? '' : warehouse.en_address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_address')" />
                            </div>
                          </li>
                          <li class="pdR40 marginB10">
                            <p class="p-title">联系方式(中文)：<a class="add-btn" @click="addOfficeContacts(warehouse, 1)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in warehouse.contacts" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 1)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in warehouse.contacts_new" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 1, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="warehouse.contacts.length === 0 && warehouse.contacts_new.length === 0">暂无信息~</div>
                          </li>
                          <li class="pdR40 marginB10">
                            <p class="p-title">Contact(外语)：<a class="add-btn" @click="addOfficeContacts(warehouse, 2)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in warehouse.en_contacts" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 2)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="identifier-box clearFl" v-for="(contact) in warehouse.en_contacts_new" :key="contact.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 2, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="warehouse.en_contacts.length === 0 && warehouse.en_contacts_new.length === 0">暂无信息~</div>
                          </li>
                        </ul>
                        <div class="marginB20">
                          <p class="p-title">说明：</p>
                          <a-textarea placeholder="请输入说明" :defaultValue="warehouse.comment === 'null' || !warehouse.comment  ? '' : warehouse.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'comment')" />
                        </div>
                        <div style="padding-bottom: 10px;">
                          <p class="p-title">附件：<a class="add-btn" @click="addFile(warehouse)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="p-file-box clearFl" v-for="(list, index) in warehouse.media" :key="list.id">
                            <div class="file-name">
                              <a-input :value="list.name" placeholder="请选择附件" disabled />
                            </div>
                            <div class="file-btn">
                              <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, warehouse, list)">
                                <a-button size="small">选择文件</a-button>
                              </a-upload>
                            </div>
                            <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, warehouse)"></div>
                          </div>
                          <div class="no-data" v-if="warehouse.media.length === 0">暂无信息~</div>
                        </div>
                        <div class="clearFl">
                          <div class="fl save-btn" @click="saveWarehouse(item, warehouse.id)">保存</div>
                          <div class="fl cancel-btn" @click="cancelWarehouse(item, warehouse.id)">取消</div>
                        </div>
                      </div>
                      <div class="fr" style="width: 7.8864%">
                        <div v-if="canDo('company.warehouse.status.update')" style="padding-left: 20px;">
                          <p class="p-title">使用/注销：</p>
                          <a-switch class="switch-btn" :checked="(warehouse.status === 1 ? true : false)" @change="ifShow($event, warehouse, 'warehouse', item.id)" />
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="part-tit clearFl">
                        <b>#{{ i + 1 }}</b>
                        <div class="fl" :class="canDo('company.warehouse.statusLogs') ? 'pointer' : ''" v-if="warehouse.status === 1" @click="showStatusLog(warehouse.id, 'warehouse')"><i class="iconfont icondaishenhe fl" style="color: #4ed0ae;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>使用中</div>
                        <div class="fl" :class="canDo('company.warehouse.statusLogs') ? 'pointer' : ''" v-else-if="warehouse.status === 0" @click="showStatusLog(warehouse.id, 'warehouse')"><i class="iconfont icondaishenhe fl" style="color: #ff4d50;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>已注销</div>
                      </div>
                      <div class="c-list clearFl">
                        <div class="fl pdR20" style="width:26.92%">
                          <span class="fl" style="color: #bbb;">中文名称：</span>
                          <span :title="warehouse.name ? warehouse.name : publicJS.blankData" class="fl p-ellipsis" style="max-width: calc(100% - 78px);">{{ warehouse.name ? warehouse.name : publicJS.blankData }}</span>
                          <div class="p-tip-b fl">
                            <div class="iconfont iconshiyi lineH14"></div>
                            <div class="p-tip-1 left-b">
                              <div class="arrow iconfont iconsanjiao"></div>
                              <div class="tip-box pd20" style="width: 200px;">
                                {{ warehouse.comment ? warehouse.comment : publicJS.blankData }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="fl p-ellipsis pdR20" style="width:26.92%">
                          <span style="color: #bbb;">外语名称：</span>
                          <span :title="warehouse.en_name ? warehouse.en_name : publicJS.blankData">{{ warehouse.en_name ? warehouse.en_name : publicJS.blankData }}</span>
                        </div>
                        <div class="fl p-ellipsis pdR20" style="width:15.38%">
                          <span style="color: #bbb;">附件：</span>
                          <a-popover v-if="warehouse.media.length > 0" placement="bottomLeft"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            arrowPointAtCenter>
                            <template slot="content">
                              <div class="download-list">
                                <p>附件</p>
                                <downPrd :media="warehouse.media"></downPrd>
                              </div>
                            </template>
                            <span class="icon iconfont iconliebiaofujian"></span>
                          </a-popover>
                          <span v-else>{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div class="c-list">
                        <div class="mgB8 positionRe" style="padding-left: 68px;">
                          <span class="c-little-tit">地址(中文)：</span>
                          <span>{{ warehouse.cnAddress ? warehouse.cnAddress : publicJS.blankData }}</span>
                          <span style="margin-left: 12px;">邮编：{{ warehouse.postcode ? warehouse.postcode : publicJS.blankData }}</span>
                        </div>
                        <div class="positionRe" style="padding-left: 48px;">
                          <span class="c-little-tit">联系人：</span>
                          <span style="margin-right: 12px;" v-for="(contact) in warehouse.contacts" :key="contact.id">
                            {{ contact.contacts + '/' + contact.tel + '；' }}
                          </span>
                          <span v-if="warehouse.contacts.length === 0">{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div class="c-list" :style="{ 'margin-bottom': (canDo('company.warehouse.update') ? '' : '0') }">
                        <div class="mgB8 positionRe" style="padding-left: 68px;">
                          <span class="c-little-tit">地址(外语)：</span>
                          <span>{{ warehouse.enAddress ? warehouse.enAddress : publicJS.blankData }}</span>
                          <span style="margin-left: 12px;">Postcode: {{ warehouse.en_postcode ? warehouse.en_postcode : publicJS.blankData }}</span>
                        </div>
                        <div class="positionRe" style="padding-left: 48px;">
                          <span class="c-little-tit">联系人：</span>
                          <span style="margin-right: 12px;" v-for="(contact) in warehouse.en_contacts" :key="contact.id">
                            {{ contact.contacts + '/' + contact.tel + '；' }}
                          </span>
                          <span v-if="warehouse.en_contacts.length === 0">{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div v-if="canDo('company.warehouse.update')" style="padding-top: 2px;">
                        <span class="edit-btn" @click="editWarehouse(warehouse, item.id)"><i class="iconfont iconbianji"></i>编辑</span>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul>
                  <li class="clearFl" v-for="(warehouse) in item.new_warehouse" :key="warehouse.id">
                    <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                      <ul class="float type2 clearFl" style="margin-right: -40px;">
                        <li class="pdR40 marginB20">
                          <p class="p-title must">中文名称：</p>
                          <a-input placeholder="请输入中文公司名称" :defaultValue="warehouse.name" @blur="e => changeOfficeValue(e.target.value, warehouse, 'name')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">外语名称：</p>
                          <a-input placeholder="Foreign company name" :defaultValue="warehouse.en_name" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_name')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">地址(中文)：</p>
                          <div class="clearFl marginB10">
                            <div class="fl pdR10" style="width: 20%">
                              <a-select
                                show-search
                                placeholder="请选择"
                                option-filter-prop="children"
                                :style="{width: '100%', color: (warehouse.country ? '': '#bbb')}"
                                :filter-option="filterOption"
                                :defaultValue="warehouse.country ? warehouse.country : '请选择国家'"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                @change="changeOfficeValue($event, warehouse, 'country')"
                              >
                                <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.name">
                                  {{ child.name }}
                                </a-select-option>
                              </a-select>
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="省" :defaultValue="warehouse.province" @blur="e => changeOfficeValue(e.target.value, warehouse, 'province')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="市" :defaultValue="warehouse.city" @blur="e => changeOfficeValue(e.target.value, warehouse, 'city')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="区" :defaultValue="warehouse.area" @blur="e => changeOfficeValue(e.target.value, warehouse, 'area')" />
                            </div>
                            <div class="fl" style="width: 20%">
                              <a-input placeholder="请输入邮编" :defaultValue="warehouse.postcode" @blur="e => changeOfficeValue(e.target.value, warehouse, 'postcode')" />
                            </div>
                          </div>
                          <div>
                            <a-textarea placeholder="请输入详细地址" :defaultValue="warehouse.address === 'null' || !warehouse.address  ? '' : warehouse.address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'address')" />
                          </div>
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">Address(外语)：</p>
                          <div class="clearFl marginB10">
                            <div class="fl pdR10" style="width: 20%">
                              <a-select
                                show-search
                                placeholder="Country"
                                option-filter-prop="children"
                                :style="{width: '100%', color: (warehouse.en_country ? '': '#bbb')}"
                                :filter-option="filterOption"
                                :defaultValue="warehouse.en_country ? warehouse.en_country : 'Country'"
                                :getPopupContainer="triggerNode => triggerNode.parentNode"
                                @change="changeOfficeValue($event, warehouse, 'en_country')"
                              >
                                <a-select-option v-for="(child) in countrys" :key="child.id" :value="child.en_name">
                                  {{ child.en_name }}
                                </a-select-option>
                              </a-select>
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Province" :defaultValue="warehouse.en_province" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_province')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="City" :defaultValue="warehouse.en_city" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_city')" />
                            </div>
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Region" :defaultValue="warehouse.en_area" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_area')" />
                            </div>
                            <div class="fl" style="width: 20%">
                              <a-input placeholder="Zip code" :defaultValue="warehouse.en_postcode" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_postcode')" />
                            </div>
                          </div>
                          <div>
                            <a-textarea placeholder="Address" :defaultValue="warehouse.en_address === 'null' || !warehouse.en_address  ? '' : warehouse.en_address" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'en_address')" />
                          </div>
                        </li>
                        <li class="pdR40 marginB10">
                          <p class="p-title">联系方式(中文)：<a class="add-btn" @click="addOfficeContacts(warehouse, 1)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="identifier-box clearFl" v-for="(contact) in warehouse.contacts_new" :key="contact.id">
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="请输入联系人" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                            </div>
                            <div class="fl" style="width: 75.68%;">
                              <a-input placeholder="请输入电话号码" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                            </div>
                            <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 1, 1)"></i>
                          </div>
                          <div class="no-data" v-if="warehouse.contacts_new.length === 0">暂无信息~</div>
                        </li>
                        <li class="pdR40 marginB10">
                          <p class="p-title">Contact(外语)：<a class="add-btn" @click="addOfficeContacts(warehouse, 2)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="identifier-box clearFl" v-for="(contact) in warehouse.en_contacts_new" :key="contact.id">
                            <div class="fl pdR10" style="width: 20%">
                              <a-input placeholder="Contacts" :defaultValue="contact.contacts" @blur="e => changeOfficeValue(e.target.value, contact, 'contacts')" />
                            </div>
                            <div class="fl" style="width: 75.68%;">
                              <a-input placeholder="Telephone" :defaultValue="contact.tel" @blur="e => changeOfficeValue(e.target.value, contact, 'tel')" />
                            </div>
                            <i class="iconfont iconshanchu1" @click="deleteContact(contact.id, warehouse, 2, 1)"></i>
                          </div>
                          <div class="no-data" v-if="warehouse.en_contacts_new.length === 0">暂无信息~</div>
                        </li>
                      </ul>
                      <div class="marginB20">
                        <p class="p-title">说明：</p>
                        <a-textarea placeholder="请输入说明" :defaultValue="warehouse.comment === 'null' || !warehouse.comment  ? '' : warehouse.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, warehouse, 'comment')" />
                      </div>
                      <div style="padding-bottom: 10px;">
                        <p class="p-title">附件：<a class="add-btn" @click="addFile(warehouse)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                        <div class="p-file-box clearFl" v-for="(list, index) in warehouse.media" :key="list.id">
                          <div class="file-name">
                            <a-input :value="list.name" placeholder="请选择附件" disabled />
                          </div>
                          <div class="file-btn">
                            <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, warehouse, list)">
                              <a-button size="small">选择文件</a-button>
                            </a-upload>
                          </div>
                          <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, warehouse)"></div>
                        </div>
                        <div class="no-data" v-if="warehouse.media.length === 0">暂无信息~</div>
                      </div>
                      <div class="clearFl">
                        <div class="fl save-btn" @click="saveWarehouse(item, warehouse.id, 1)">保存</div>
                        <div class="fl cancel-btn" @click="cancelWarehouse(item, warehouse.id, 1)">取消</div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="companyInfo-more" width="100%" v-else-if="item.radioValue === 3">
        <tbody>
          <tr>
            <td width="19.28%" align="center" style="padding: 18px 40px 30px 0;">
              <div class="left-part">
                <div class="marginB9 bankAccount"></div>
                <div :class="canDo('company.bank.update') ? 'marginB9' : ''">银行账户信息</div>
                <div v-if="canDo('company.bank.update')" class="add-info" :class="canEdit ? '' : 'disabled'" @click="addAccount(item)"></div>
              </div>
            </td>
            <td valign="top" style="padding: 18px 20px 30px;">
              <div class="right-part">
                <ul>
                  <li :class="item.new_bank.length > 0 ? 'not-last' : ''" v-for="(bank, i) in item.bank" :key="bank.id">
                    <div class="clearFl" v-if="bank.editStatus">
                      <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                        <ul class="float type2 clearFl" style="margin-right: -40px;">
                          <li class="pdR40 marginB20">
                            <p class="p-title must">收款方式：</p>
                            <a-input placeholder="请输入收款方式" :defaultValue="bank.pay_method" @blur="e => changeOfficeValue(e.target.value, bank, 'pay_method')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title">支票接收地址：</p>
                            <a-input placeholder="请输入支票接受地址" :defaultValue="bank.check_address" @blur="e => changeOfficeValue(e.target.value, bank, 'check_address')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">Bank Name：</p>
                            <a-input placeholder="请输入收款行名称" :defaultValue="bank.bank_name" @blur="e => changeOfficeValue(e.target.value, bank, 'bank_name')" />
                          </li>
                          <li class="pdR40 marginB20">
                            <p class="p-title must">Account Name：</p>
                            <a-input placeholder="请输入收款人账户名" :defaultValue="bank.account_name" @blur="e => changeOfficeValue(e.target.value, bank, 'account_name')" />
                          </li>
                          <li class="pdR40" style="margin-bottom: 10px;">
                            <p class="p-title">银行信息：<a class="add-btn" @click="addBankInfo(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="identifier-box clearFl" v-for="(account) in bank.other_info.accounts" :key="account.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入标题" :defaultValue="account.tit" @blur="e => changeOfficeValue(e.target.value, account, 'tit')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入内容" :defaultValue="account.con" @blur="e => changeOfficeValue(e.target.value, account, 'con')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteBankInfo(account.id, bank)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="identifier-box clearFl" v-for="(account) in bank.other_info.accounts_new" :key="account.id">
                                <div class="fl pdR10" style="width: 20%">
                                  <a-input placeholder="请输入标题" :defaultValue="account.tit" @blur="e => changeOfficeValue(e.target.value, account, 'tit')" />
                                </div>
                                <div class="fl" style="width: 75.68%;">
                                  <a-input placeholder="请输入内容" :defaultValue="account.con" @blur="e => changeOfficeValue(e.target.value, account, 'con')" />
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteBankInfo(account.id, bank, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="bank.other_info.accounts && bank.other_info.accounts.length === 0 && bank.other_info.accounts_new && bank.other_info.accounts_new.length === 0">暂无信息~</div>
                          </li>
                          <li class="pdR40" style="margin-bottom: 10px;">
                            <p class="p-title must">账户信息：<a class="add-btn" @click="addAccountInfo(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                            <div>
                              <div class="account-info" v-for="(account) in bank.account_info" :key="account.id">
                                <div class="account-list clearFl">
                                  <div class="fl pdR10" style="width: 24.52%">
                                    <a-select
                                      show-search
                                      placeholder="请选择币种"
                                      option-filter-prop="children"
                                      :style="{width: '100%', color: (account.currency ? '': '#bbb')}"
                                      :filter-option="filterOption"
                                      :defaultValue="account.currency ? account.currency : '请选择币种'"
                                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                                      @change="changeOfficeValue($event, account, 'currency')"
                                    >
                                      <a-select-option v-for="(child) in currencies" :key="child.id" :value="child.name">
                                        {{ child.name }}
                                      </a-select-option>
                                    </a-select>
                                  </div>
                                  <div class="fl" style="width: 75.48%">
                                    <a-input placeholder="Account Number" :defaultValue="account.account_number" @blur="e => changeOfficeValue(e.target.value, account, 'account_number')" />
                                  </div>
                                  <i class="iconfont" @click="addAccountList(account)">+</i>
                                </div>
                                <div>
                                  <div class="account-list clearFl" v-for="(list) in account.other_info.lists" :key="list.id">
                                    <div class="fl pdR10" style="width: 24.52%">
                                      <a-input placeholder="请输入标题" :defaultValue="list.tit" @blur="e => changeOfficeValue(e.target.value, list, 'tit')" />
                                    </div>
                                    <div class="fl" style="width: 75.48%">
                                      <a-input placeholder="请输入内容" :defaultValue="list.con" @blur="e => changeOfficeValue(e.target.value, list, 'con')" />
                                    </div>
                                    <i class="iconfont" style="font-size: 20px;" @click="deleteAccountList(list.id, account)">-</i>
                                  </div>
                                </div>
                                <div>
                                  <div class="account-list clearFl" v-for="(list) in account.other_info.lists_new" :key="list.id">
                                    <div class="fl pdR10" style="width: 24.52%">
                                      <a-input placeholder="请输入标题" :defaultValue="list.tit" @blur="e => changeOfficeValue(e.target.value, list, 'tit')" />
                                    </div>
                                    <div class="fl" style="width: 75.48%">
                                      <a-input placeholder="请输入内容" :defaultValue="list.con" @blur="e => changeOfficeValue(e.target.value, list, 'con')" />
                                    </div>
                                    <i class="iconfont" style="font-size: 20px;" @click="deleteAccountList(list.id, account, 1)">-</i>
                                  </div>
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteAccountInfo(bank, account.id)"></i>
                              </div>
                            </div>
                            <div>
                              <div class="account-info" v-for="(account) in bank.account_info_new" :key="account.id">
                                <div class="account-list clearFl">
                                  <div class="fl pdR10" style="width: 24.52%">
                                    <a-select
                                      show-search
                                      placeholder="请选择"
                                      option-filter-prop="children"
                                      :style="{width: '100%', color: (account.currency ? '': '#bbb')}"
                                      :filter-option="filterOption"
                                      :defaultValue="account.currency ? account.currency : '请选择币种'"
                                      :getPopupContainer="triggerNode => triggerNode.parentNode"
                                      @change="changeOfficeValue($event, account, 'currency')"
                                    >
                                      <a-select-option v-for="(child) in currencies" :key="child.id" :value="child.name">
                                        {{ child.name }}
                                      </a-select-option>
                                    </a-select>
                                  </div>
                                  <div class="fl" style="width: 75.48%">
                                    <a-input placeholder="请输入内容" :defaultValue="account.account_number" @blur="e => changeOfficeValue(e.target.value, account, 'account_number')" />
                                  </div>
                                  <i class="iconfont" @click="addAccountList(account)">+</i>
                                </div>
                                <div>
                                  <div class="account-list clearFl" v-for="(list) in account.other_info.lists" :key="list.id">
                                    <div class="fl pdR10" style="width: 24.52%">
                                      <a-input placeholder="请输入标题" :defaultValue="list.tit" @blur="e => changeOfficeValue(e.target.value, list, 'tit')" />
                                    </div>
                                    <div class="fl" style="width: 75.48%">
                                      <a-input placeholder="请输入内容" :defaultValue="list.con" @blur="e => changeOfficeValue(e.target.value, list, 'con')" />
                                    </div>
                                    <i class="iconfont" style="font-size: 20px;" @click="deleteAccountList(list.id, account)">-</i>
                                  </div>
                                </div>
                                <div>
                                  <div class="account-list clearFl" v-for="(list) in account.other_info.lists_new" :key="list.id">
                                    <div class="fl pdR10" style="width: 24.52%">
                                      <a-input placeholder="请输入标题" :defaultValue="list.tit" @blur="e => changeOfficeValue(e.target.value, list, 'tit')" />
                                    </div>
                                    <div class="fl" style="width: 75.48%">
                                      <a-input placeholder="请输入内容" :defaultValue="list.con" @blur="e => changeOfficeValue(e.target.value, list, 'con')" />
                                    </div>
                                    <i class="iconfont" style="font-size: 20px;" @click="deleteAccountList(list.id, account, 1)">-</i>
                                  </div>
                                </div>
                                <i class="iconfont iconshanchu1" @click="deleteAccountInfo(bank, account.id, 1)"></i>
                              </div>
                            </div>
                            <div class="no-data" v-if="bank.account_info_new.length === 0 && bank.account_info.length === 0">暂无信息~</div>
                          </li>
                        </ul>
                        <div class="marginB20">
                          <p class="p-title">说明：</p>
                          <a-textarea placeholder="请输入说明" :defaultValue="bank.comment === 'null' || !bank.comment  ? '' : bank.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, bank, 'comment')" />
                        </div>
                        <div style="padding-bottom: 10px;">
                          <p class="p-title">附件：<a class="add-btn" @click="addFile(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div class="p-file-box clearFl" v-for="(list, index) in bank.media" :key="list.id">
                            <div class="file-name">
                              <a-input :value="list.name" placeholder="请选择附件" disabled />
                            </div>
                            <div class="file-btn">
                              <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, bank, list)">
                                <a-button size="small">选择文件</a-button>
                              </a-upload>
                            </div>
                            <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, bank)"></div>
                          </div>
                          <div class="no-data" v-if="bank.media.length === 0">暂无信息~</div>
                        </div>
                        <div class="clearFl">
                          <div class="fl save-btn" @click="saveBank(item, bank.id)">保存</div>
                          <div class="fl cancel-btn" @click="cancelBank(item, bank.id)">取消</div>
                        </div>
                      </div>
                      <div class="fr" style="width: 7.8864%">
                        <div v-if="canDo('company.bank.status.update')" style="padding-left: 20px;">
                          <p class="p-title">使用/注销：</p>
                          <a-switch class="switch-btn" :checked="(bank.status === 1 ? true : false)" @change="ifShow($event, bank, 'bank', item.id)" />
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="part-tit clearFl">
                        <b>#{{ i + 1 }}</b>
                        <div class="fl" :class="canDo('company.bank.statusLogs') ? 'pointer' : ''" v-if="bank.status === 1" @click="showStatusLog(bank.id, 'bank')"><i class="iconfont icondaishenhe fl" style="color: #4ed0ae;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>使用中</div>
                        <div class="fl" :class="canDo('company.bank.statusLogs') ? 'pointer' : ''" v-else-if="bank.status === 0" @click="showStatusLog(bank.id, 'bank')"><i class="iconfont icondaishenhe fl" style="color: #ff4d50;font-size: 14px;margin-right: 4px;margin-top: 1px;"></i>已注销</div>
                      </div>
                      <div class="c-list clearFl">
                        <div class="fl pdR20" style="width:26.92%">
                          <span class="fl" style="color: #bbb;">收款方式：</span>
                          <span :title="bank.pay_method ? bank.pay_method : publicJS.blankData" class="fl p-ellipsis" style="max-width: calc(100% - 78px);">
                            {{ bank.pay_method ? bank.pay_method : publicJS.blankData }}
                          </span>
                          <div class="p-tip-b fl">
                            <div class="iconfont iconshiyi lineH14"></div>
                            <div class="p-tip-1 left-b">
                              <div class="arrow iconfont iconsanjiao"></div>
                              <div class="tip-box pd20" style="width: 200px;">
                                {{ bank.comment ? bank.comment : publicJS.blankData }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="fl p-ellipsis pdR20" style="width:15.38%">
                          <span style="color: #bbb;">附件：</span>
                          <a-popover v-if="bank.media.length > 0" placement="bottomLeft"
                            :getPopupContainer="triggerNode => triggerNode.parentNode"
                            arrowPointAtCenter>
                            <template slot="content">
                              <div class="download-list">
                                <p>附件</p>
                                <downPrd :media="bank.media"></downPrd>
                              </div>
                            </template>
                            <span class="icon iconfont iconliebiaofujian"></span>
                          </a-popover>
                          <span v-else>{{ publicJS.blankData }}</span>
                        </div>
                      </div>
                      <div class="c-list" style="padding-left: 92px;">
                        <span class="c-little-tit">支票接收地址：</span>
                        <span>{{ bank.check_address ? bank.check_address : publicJS.blankData }}</span>
                      </div>
                      <div class="c-list">
                        <div class="mgB8">银行信息</div>
                        <div>
                          <div class="mgB8 positionRe">
                            <span style="color: #bbb;">Bank Name：</span>
                            <span>{{ bank.bank_name }}</span>
                          </div>
                        </div>
                        <div v-if="bank.other_info.accounts.length > 0">
                          <div class="mgB8 positionRe" v-for="(child, j) in bank.other_info.accounts" :key="j">
                            <span style="color: #bbb;">{{ child.tit }}：</span>
                            <span>{{ child.con }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="c-list" :style="{ 'margin-bottom': (canDo('company.bank.update') ? '10px' : '0') }">
                        <div class="mgB8">账户信息</div>
                        <div class="mgB8 positionRe">
                          <span style="color: #bbb;">Account Name：</span>
                          <span>{{ bank.account_name }}</span>
                        </div>
                        <div class="clearFl">
                          <div v-for="(child, j) in bank.account_info" :key="j">
                            <div class="fl pdR20 marginB10 account-info-list" :style="{width: ((j + 1) % 4 === 0 ? '19.24%' : '26.92%')}">
                              <div class="p-ellipsis">
                                <span class="fl" style="color: #bbb;">{{ child.currency }}-Acc.-No.：</span>
                                <span :title="child.account_number ? child.account_number : publicJS.blankData">{{ child.account_number ? child.account_number : publicJS.blankData }}</span>
                              </div>
                              <div class="p-ellipsis" v-for="(account, k) in child.other_info.lists" :key="k">
                                <span class="fl" style="color: #bbb;">{{ child.currency }}-{{ account.tit }}：</span>
                                <span :title="account.con">{{ account.con }}</span>
                              </div>
                            </div>
                            <div class="clearFl" v-if="(j + 1) % 4 === 0"></div>
                          </div>
                        </div>
                      </div>
                      <div v-if="canDo('company.bank.update')" style="padding-top: 2px;">
                        <span class="edit-btn" @click="editBank(bank, item.id)"><i class="iconfont iconbianji"></i>编辑</span>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul>
                  <li class="clearFl" v-for="(bank) in item.new_bank" :key="bank.id">
                    <div class="fl" style="width: 92.1138%; padding-right: 20px;">
                      <ul class="float type2 clearFl" style="margin-right: -40px;">
                        <li class="pdR40 marginB20">
                          <p class="p-title must">收款方式：</p>
                          <a-input placeholder="请输入收款方式" :defaultValue="bank.pay_method" @blur="e => changeOfficeValue(e.target.value, bank, 'pay_method')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title">支票接收地址：</p>
                          <a-input placeholder="请输入支票接受地址" :defaultValue="bank.check_address" @blur="e => changeOfficeValue(e.target.value, bank, 'check_address')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">Bank Name：</p>
                          <a-input placeholder="请输入收款行名称" :defaultValue="bank.bank_name" @blur="e => changeOfficeValue(e.target.value, bank, 'bank_name')" />
                        </li>
                        <li class="pdR40 marginB20">
                          <p class="p-title must">Account Name：</p>
                          <a-input placeholder="请输入收款人账户名" :defaultValue="bank.account_name" @blur="e => changeOfficeValue(e.target.value, bank, 'account_name')" />
                        </li>
                        <li class="pdR40" style="margin-bottom: 10px;">
                          <p class="p-title">银行信息：<a class="add-btn" @click="addBankInfo(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div>
                            <div class="identifier-box clearFl" v-for="(account) in bank.other_info.accounts_new" :key="account.id">
                              <div class="fl pdR10" style="width: 20%">
                                <a-input placeholder="请输入标题" :defaultValue="account.tit" @blur="e => changeOfficeValue(e.target.value, account, 'tit')" />
                              </div>
                              <div class="fl" style="width: 75.68%;">
                                <a-input placeholder="请输入内容" :defaultValue="account.con" @blur="e => changeOfficeValue(e.target.value, account, 'con')" />
                              </div>
                              <i class="iconfont iconshanchu1" @click="deleteBankInfo(account.id, bank, 1)"></i>
                            </div>
                          </div>
                          <div class="no-data" v-if="bank.other_info.accounts_new.length === 0">暂无信息~</div>
                        </li>
                        <li class="pdR40" style="margin-bottom: 10px;">
                          <p class="p-title must">账户信息：<a class="add-btn" @click="addAccountInfo(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                          <div>
                            <div class="account-info" v-for="(account) in bank.account_info_new" :key="account.id">
                              <div class="account-list clearFl">
                                <div class="fl pdR10" style="width: 24.52%">
                                  <a-select
                                    show-search
                                    placeholder="请选择币种"
                                    option-filter-prop="children"
                                    :style="{width: '100%', color: (account.currency ? '': '#bbb')}"
                                    :filter-option="filterOption"
                                    :defaultValue="account.currency ? account.currency : '请选择币种'"
                                    :getPopupContainer="triggerNode => triggerNode.parentNode"
                                    @change="changeOfficeValue($event, account, 'currency')"
                                  >
                                    <a-select-option v-for="(child) in currencies" :key="child.id" :value="child.name">
                                      {{ child.name }}
                                    </a-select-option>
                                  </a-select>
                                </div>
                                <div class="fl" style="width: 75.48%">
                                  <a-input placeholder="Account Number" :defaultValue="account.account_number" @blur="e => changeOfficeValue(e.target.value, account, 'account_number')" />
                                </div>
                                <i class="iconfont" @click="addAccountList(account)">+</i>
                              </div>
                              <div>
                                <div class="account-list clearFl" v-for="(list) in account.other_info.lists_new" :key="list.id">
                                  <div class="fl pdR10" style="width: 24.52%">
                                    <a-input placeholder="请输入标题" :defaultValue="list.tit" @blur="e => changeOfficeValue(e.target.value, list, 'tit')" />
                                  </div>
                                  <div class="fl" style="width: 75.48%">
                                    <a-input placeholder="请输入内容" :defaultValue="list.con" @blur="e => changeOfficeValue(e.target.value, list, 'con')" />
                                  </div>
                                  <i class="iconfont" style="font-size: 20px;" @click="deleteAccountList(list.id, account, 1)">-</i>
                                </div>
                              </div>
                              <i class="iconfont iconshanchu1" @click="deleteAccountInfo(bank, account.id, 1)"></i>
                            </div>
                          </div>
                          <div class="no-data" v-if="bank.account_info_new.length === 0">暂无信息~</div>
                        </li>
                      </ul>
                      <div class="marginB20">
                        <p class="p-title">说明：</p>
                        <a-textarea placeholder="请输入说明" :defaultValue="bank.comment === 'null' || !bank.comment  ? '' : bank.comment" style="height: 80px;" @blur="e => changeOfficeValue(e.target.value, bank, 'comment')" />
                      </div>
                      <div style="padding-bottom: 10px;">
                        <p class="p-title">附件：<a class="add-btn" @click="addFile(bank)"><i class="iconfont iconxinzeng"></i>添加</a></p>
                        <div class="p-file-box clearFl" v-for="(list, index) in bank.media" :key="list.id">
                          <div class="file-name">
                            <a-input :value="list.name" placeholder="请选择附件" disabled />
                          </div>
                          <div class="file-btn">
                            <a-upload :showUploadList="false" :beforeUpload="(file) => beforeUpload(file, index, bank, list)">
                              <a-button size="small">选择文件</a-button>
                            </a-upload>
                          </div>
                          <div class="file-delete iconfont iconshanchu2" @click="() => removeFile(index, bank)"></div>
                        </div>
                        <div class="no-data" v-if="bank.media.length === 0">暂无信息~</div>
                      </div>
                      <div class="clearFl">
                        <div class="fl save-btn" @click="saveBank(item, bank.id, 1)">保存</div>
                        <div class="fl cancel-btn" @click="cancelBank(item, bank.id, 1)">取消</div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 使用/注销 -->
    <a-modal
      class="normal-modal"
      width="380px"
      :title="logoutText"
      :visible="visibleLogout"
      :confirm-loading="logoutLoading"
      :maskClosable="false"
      @ok="logoutOk"
      @cancel="logoutCancel"
    >
      <div>
        <p class="p-title must">备注：</p>
        <a-textarea :placeholder="logoutPlaceholder" style="height: 80px;" v-model="logoutReason" />
      </div>
    </a-modal>
    <!-- 取消修改提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleSaveEdit"
      :confirm-loading="false"
      :maskClosable="false"
      @ok="cancelEditOk"
      @cancel="cancelEditCancel"
    >
      <p class="tip-txt">所编辑内容<span style="color: #FF4A4A;">将被取消</span>！</p>
    </a-modal>
    <!-- 保存编辑提示框 -->
    <a-modal
      class="tip-modal"
      width="380px"
      title="提示"
      :visible="visibleEdit"
      :confirm-loading="editUpdateLoading"
      :maskClosable="false"
      @ok="editOk"
      @cancel="editCancel"
    >
      <p class="tip-txt">所编辑内容<span style="color: #FEB300;">将被更新</span>！</p>
    </a-modal>
    <!-- 记录 -->
    <a-modal
      class="normal-modal company-status-log"
      width="700px"
      title="状态变动记录"
      :visible="visibleStatusLog"
      :confirm-loading="false"
      :maskClosable="true"
      :footer="null"
      @cancel="statusLogCancel"
    >
      <div>
        <a-table
          :columns="columnsLog"
          :data-source="listLog"
          :loading="loadingLog"
          :pagination="false"
          :scroll="{ y: 600 }"
          rowKey="created_at"
          class="table-log"
        >
          <template slot="statusLog" slot-scope="text">
            <div :style="{'color': (text === '运营中' ? '#3DCCA6' : ( text === '已注销' ? '#FF4A4A' : '#378EEF' ))}">{{ text }}</div>
          </template>
          <template slot="user_name" slot-scope="text">
            <div style="color: #666;">{{ text }}</div>
          </template>
          <template slot="comment" slot-scope="text">
            <div class="p-ellipsis" style="color: #666;" :title="text">{{ text }}</div>
          </template>
        </a-table>
      </div>
    </a-modal>
  </div>
</template>
<script>
import { getCompanyInfoList, getCompanyOfficeInfo, getCompanyWarehouseInfo, getCompanyBankInfo, updateCompanyRegistryInfo, getCompanyInfo, updateCompanyOfficeInfo, updateCompanyWarehouseInfo, updateCompanyBankInfo, updateCompanyMoreInfoStatus, getCompanyCurrencies, getCompanyOfficeStatusLog, getCompanyWarehouseStatusLog, getCompanyBankStatusLog } from '../../../api/toolManagement/companyInfomation/index'
import { getCountrys } from '../../../api/toolManagement/mainCompany/index'
import { allow, allowSize, canDo } from '@/plugins/common.js'
import downPrd from '@/components/downPrd'
import _ from 'lodash'

const columnsLog = [
  {
    title: '时间',
    dataIndex: 'created_at',
    key: 'created_at',
    width: '24.55%'
  }, {
    title: '状态',
    dataIndex: 'status',
    key: 'status',
    scopedSlots: { customRender: 'statusLog' },
    width: '13.03%'
  }, {
    title: '操作人',
    dataIndex: 'user_name',
    key: 'user_name',
    scopedSlots: { customRender: 'user_name' },
    width: '15.76%'
  }, {
    title: '备注',
    dataIndex: 'comment',
    key: 'comment',
    scopedSlots: { customRender: 'comment' }
  }
]

export default {
  data () {
    return {
      companyInfo: [],
      companyInfoCache: [],
      countrys: [],
      currencies: [],
      listLog: [],
      columnsLog: columnsLog,
      visibleLogout: false,
      logoutLoading: false,
      logoutText: '',
      logoutName: '',
      logoutPlaceholder: '',
      logoutId: -1,
      logoutReason: '',
      logoutChecked: true,
      el: '',
      editName: '',
      visibleSaveEdit: false,
      editId: -1,
      editParentId: -1,
      canEditID: -1,
      canEdit: true,
      canAdd: true,
      isNew: true,
      visibleEdit: false,
      editUpdateLoading: false,
      visibleStatusLog: false,
      loadingLog: false,
      editType: 0
    }
  },
  components: {
    downPrd
  },
  created () {
    getCompanyInfoList().then(res => {
      if (res.code === 200) {
        this.companyInfo = res.data.map(item => {
          item['radioValue'] = 0
          item['editStatus'] = false
          item['new_tax_id'] = 0
          item['new_tax'] = []
          item['new_office_id'] = 0
          item['new_warehouse_id'] = 0
          item['new_bank_id'] = 0
          item['address']['cnAddress'] = (item.address.country ? item.address.country : '') + (item.address.province ? item.address.province : '') + (item.address.city ? item.address.city : '') + (item.address.area ? item.address.area : '') + (item.address.address ? item.address.address : '')
          item['address']['enAddress'] = (item.address.en_address ? item.address.en_address + ',' : '') + (item.address.en_area ? item.address.en_area + ',' : '') + (item.address.en_city ? item.address.en_city + ',' : '') + (item.address.en_province ? item.address.en_province + ',' : '') + (item.address.en_country ? item.address.en_country : '')
          this.$set(item, 'newOffice', [])
          this.$set(item, 'new_warehouse', [])
          this.$set(item, 'new_bank', [])
          return item
        })
        // 缓存注册信息数据
        this.companyInfoCache = JSON.parse(JSON.stringify(this.companyInfo))
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    // 获取国家数据
    getCountrys().then(res => {
      if (res.code === 200) {
        // 将国家数据转换成json格式
        for (let key in res.data) {
          this.countrys.push({ id: key, name: res.data[key].zh, en_name: res.data[key].en })
        }
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
    // 获取货币信息
    getCompanyCurrencies().then(res => {
      if (res.code === 200) {
        // 将货币数据转换成json格式
        for (let key in res.data.currencies) {
          this.currencies.push({ id: key, name: res.data.currencies[key] })
        }
      }
    }).catch(error => {
      this.$message.error(error.response ? error.response.data.message : error.message)
    })
  },
  methods: {
    canDo,
    changePart (e, num, item) {
      let value = e.target.checked
      if (value) {
        item.radioValue = num
        if (num === 1 && !item['office']) {
          getCompanyOfficeInfo(item.id).then(res => {
            if (res.code === 200) {
              this.$set(item, 'office', res.data.offices.map((child, i) => {
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                return child
              }))
              // this.$set(item, 'newOffice', [])
              // 缓存办公地址数据
              let target = this.companyInfoCache.filter(list => item.id === list.id)[0]
              // target['office'] = item['office'].map(list => ({ ...list }))
              this.$set(target, 'office', JSON.parse(JSON.stringify(item['office'])))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
        if (num === 2 && !item['warehouse']) {
          getCompanyWarehouseInfo(item.id).then(res => {
            if (res.code === 200) {
              this.$set(item, 'warehouse', res.data.warehouses.map((child, i) => {
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                return child
              }))
              // this.$set(item, 'new_warehouse', [])
              // 缓存仓储地址数据
              let target = this.companyInfoCache.filter(list => item.id === list.id)[0]
              this.$set(target, 'warehouse', JSON.parse(JSON.stringify(item['warehouse'])))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
        if (num === 3 && !item['bank']) {
          getCompanyBankInfo(item.id).then(res => {
            if (res.code === 200) {
              this.$set(item, 'bank', res.data.banks.map((child, i) => {
                child['editStatus'] = false
                child.other_info = JSON.parse(child.other_info)
                child.account_info.map((list, i) => {
                  list.other_info = JSON.parse(list.other_info)
                  this.$set(list.other_info, 'lists_new', [])
                  this.$set(list.other_info, 'list_id', 1)
                  list.other_info.lists.map((li, j) => {
                    this.$set(li, 'id', j + 1)
                  })
                })
                child.other_info.accounts.map((list, i) => {
                  this.$set(list, 'id', i + 1)
                })
                this.$set(child.other_info, 'accounts_new', [])
                this.$set(child.other_info, 'bank_id', 1)
                this.$set(child, 'account_info_new', [])
                this.$set(child, 'account_id', 1)
                return child
              }))
              // this.$set(item, 'new_bank', [])
              // 缓存银行信息数据
              let target = this.companyInfoCache.filter(list => item.id === list.id)[0]
              this.$set(target, 'bank', JSON.parse(JSON.stringify(item['bank'])))
            }
          }).catch(error => {
            this.$message.error(error.response ? error.response.data.message : error.message)
          })
        }
      } else {
        item.radioValue = 0
      }
    },
    editRegister (item) {
      if (!this.canEdit) {
        this.$message.warning('当前状态不可编辑其他内容！')
        return
      }
      item.editStatus = !item.editStatus
      item.radioValue = 0
      this.canEdit = false
    },
    changeValue (value, item, key) {
      // let reTarget = this.companyInfoCache.filter(list => item.id === list.id)[0]
      // 更改联系人
      if (key === 'contacts') {
        item[key] = value
        return
      }
      item['address'][key] = value
    },
    changeIdentifierValue (value, item, key) {
      item[key] = value
    },
    addIdentifier (item) {
      item.new_tax_id++
      item.new_tax.push({ id: item.new_tax_id, country: '', tax_number: '' })
    },
    deleteIdentifier (id, item, flag) {
      if (flag) {
        let newArr = [...item.new_tax]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        item.new_tax = newArr
      } else {
        let newArr1 = [...item.company_tax_info]
        _.remove(newArr1, (n) => {
          return id === n.id
        })
        item.company_tax_info = newArr1
      }
    },
    addFile (item) {
      item.media.push({ name: '', file: null, isNew: true })
    },
    beforeUpload (file, index, item, list) {
      let size = file.size / (1024 * 1024)
      let name = file.name.substring(file.name.lastIndexOf('.'))
      if (size > allowSize) {
        this.$message.error('上传文件不得超过' + allowSize + 'm')
      } else if (allow.indexOf(name) === -1) {
        this.$message.error('上传文件格式不正确')
      } else {
        item['media'][index].file = file
        item['media'][index].name = file.name
      }
      if (list.id) {
        // 更新已存在的文件
        item['media'][index].file.id = ''
        item['media'][index].isNew = true
      }
      return false
    },
    removeFile (index, item) {
      item['media'].splice(index, 1)
    },
    editOffice (office, parentId) {
      if (!this.canEdit) {
        this.$message.warning('当前状态不可编辑其他内容！')
        return
      }
      let target = _.find(this.companyInfoCache, { id: parentId })
      let indexParent = _.findIndex(this.companyInfoCache, { id: parentId })
      let index = _.findIndex(target.office, { id: office.id })
      office.editStatus = true
      this.companyInfoCache[indexParent].office[index].editStatus = true
      this.canEdit = false
      this.canEditID = parentId
    },
    saveRegister (item) {
      let target = item
      let targetCache = _.find(this.companyInfoCache, { id: item.id })
      let flag1 = true
      if (_.isEqual(target.address, targetCache.address) && _.isEqual(target.company_tax_info, targetCache.company_tax_info) && _.isEqual(target.media, targetCache.media) && _.isEqual(target.contacts, targetCache.contacts) && target.new_tax.length === 0) {
        this.$message.warning('未更改内容！')
        return
      }
      let text = (target.address.name === '' ? '公司名称、' : '') + (target.address.en_name === '' ? '外语名称、' : '') + (target.address.country === '' ? '注册国家、' : '') + (target.address.en_country === '' ? '外语注册国家、' : '') + (target.address.province === '' ? '注册省、' : '') + (target.address.en_province === '' ? '外语注册省、' : '') + (target.address.city === '' ? '注册市、' : '') + (target.address.en_city === '' ? '外语注册市、' : '') + (target.address.area === '' ? '注册区、' : '') + (target.address.en_area === '' ? '外语注册区、' : '') + (target.address.address === '' ? '注册详细地址、' : '') + (target.address.en_address === '' ? '外语注册详细地址、' : '') + (target.address.tel === '' ? '注册电话、' : '') + (target.address.en_tel === '' ? '外语注册电话' : '')
      if (target.address.name === '' || target.address.en_name === '' || target.address.country === '' || target.address.en_country === '' || target.address.province === '' || target.address.en_province === '' || target.address.city === '' || target.address.en_city === '' || target.address.area === '' || target.address.en_area === '' || target.address.address === '' || target.address.en_address === '' || target.address.tel === '' || target.address.en_tel === '') {
        this.$message.error(text + '不能为空')
        return
      }
      let pattern1 = new RegExp('[\u4e00-\u9fa5]')
      let text1 = (pattern1.test(target.address.en_name) ? '外语名称、' : '') + (pattern1.test(target.address.en_country) ? '外语注册国家、' : '') + (pattern1.test(target.address.en_province) ? '外语注册省、' : '') + (pattern1.test(target.address.en_city) ? '外语注册市、' : '') + (pattern1.test(target.address.en_area) ? '外语注册区、' : '') + (pattern1.test(target.address.en_address) ? '外语注册详细地址' : '')
      target.company_tax_info.forEach((val, index, arr) => {
        if (val.country === '' && val.tax_number !== '') {
          flag1 = false
        } else if (val.country !== '' && val.tax_number === '') {
          flag1 = false
        }
      })
      target.new_tax.forEach((val, index, arr) => {
        if (val.country === '' && val.tax_number !== '') {
          flag1 = false
        } else if (val.country !== '' && val.tax_number === '') {
          flag1 = false
        }
      })
      if (pattern1.test(target.address.en_name) || pattern1.test(target.address.en_country) || pattern1.test(target.address.en_province) || pattern1.test(target.address.en_city) || pattern1.test(target.address.en_area) || pattern1.test(target.address.en_address) || !flag1) {
        this.$message.error((text1 + (text1 ? '不能含中文；' : '')) + (!flag1 ? '纳税人识别号一组国家税号不能只填一个' : ''))
        return
      }
      this.editName = 'address'
      this.visibleEdit = true
      this.editId = item.id
    },
    updateInfo (id, key, moreInfoId, type) {
      let target = this.companyInfo.filter(list => id === list.id)[0]
      let targetCache = this.companyInfoCache.filter(list => id === list.id)[0]
      let index = _.findIndex(this.companyInfo, { id: id })
      let indexCache = _.findIndex(this.companyInfoCache, { id: id })
      let index1 = _.findIndex(target[key], { id: moreInfoId })
      let indexCache1 = _.findIndex(targetCache[key], { id: moreInfoId })
      getCompanyInfo(id).then(res => {
        if (res.code === 200) {
          if (key === 'address') {
            // 更新注册信息
            target.editStatus = false
            targetCache.editStatus = false
            target.new_tax = []
            targetCache.new_tax = []
            target.new_tax_id = 0
            targetCache.new_tax_id = 0
            target.address = res.data.company.address
            target.address['cnAddress'] = (target.address.country ? target.address.country : '') + (target.address.province ? target.address.province : '') + (target.address.city ? target.address.city : '') + (target.address.area ? target.address.area : '') + (target.address.address ? target.address.address : '')
            target.address['enAddress'] = (target.address.en_address ? target.address.en_address + ',' : '') + (target.address.en_area ? target.address.en_area + ',' : '') + (target.address.en_city ? target.address.en_city + ',' : '') + (target.address.en_province ? target.address.en_province + ',' : '') + (target.address.en_country ? target.address.en_country : '')
            target.company_tax_info = res.data.company.company_tax_info
            target.media = res.data.company.media
            target.contacts = res.data.company.contacts
            targetCache.address = JSON.parse(JSON.stringify(target.address))
            targetCache.company_tax_info = JSON.parse(JSON.stringify(target.company_tax_info))
            targetCache.media = JSON.parse(JSON.stringify(target.media))
            targetCache.contacts = JSON.parse(JSON.stringify(target.contacts))
          } else if (key === 'office') {
            // 更新办公室信息
            if (type) {
              // 新增
              let newArr = [...target.newOffice]
              _.remove(newArr, (n) => {
                return moreInfoId === n.id
              })
              target.newOffice = newArr
              res.data.office.map((child, i) => {
                let officeId = child.id
                let ifExit = _.find(target.office, { id: officeId })
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                if (!ifExit) {
                  target.office.push(child)
                  targetCache.office.push(JSON.parse(JSON.stringify(child)))
                }
              })
            } else {
              res.data.office.map((child, i) => {
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                if (child.id === moreInfoId) {
                  Object.assign(this.companyInfo[index].office[index1], JSON.parse(JSON.stringify(child)))
                  Object.assign(this.companyInfoCache[indexCache].office[indexCache1], JSON.parse(JSON.stringify(child)))
                }
              })
            }
          } else if (key === 'warehouse') {
            // 更新仓储地址信息
            if (type) {
              // 新增
              let newArr = [...target.new_warehouse]
              _.remove(newArr, (n) => {
                return moreInfoId === n.id
              })
              target.new_warehouse = newArr
              res.data.warehouse.map((child, i) => {
                let warehouseId = child.id
                let ifExit = _.find(target.warehouse, { id: warehouseId })
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                if (!ifExit) {
                  target.warehouse.push(child)
                  targetCache.warehouse.push(JSON.parse(JSON.stringify(child)))
                }
              })
            } else {
              res.data.warehouse.map((child, i) => {
                child['editStatus'] = false
                child['cnAddress'] = (child.country ? child.country + ' ' : '') + (child.province ? child.province + ' ' : '') + (child.city ? child.city + ' ' : '') + (child.area ? child.area + ' ' : '') + (child.address ? child.address + ' ' : '')
                child['enAddress'] = (child.en_address ? child.en_address + ',' : '') + (child.en_area ? child.en_area + ',' : '') + (child.en_city ? child.en_city + ',' : '') + (child.en_province ? child.en_province + ',' : '') + (child.en_country ? child.en_country : '')
                this.$set(child, 'contacts_new', [])
                this.$set(child, 'contacts_id', 0)
                this.$set(child, 'en_contacts_new', [])
                this.$set(child, 'en_contacts_id', 0)
                if (child.id === moreInfoId) {
                  Object.assign(this.companyInfo[index].warehouse[index1], JSON.parse(JSON.stringify(child)))
                  Object.assign(this.companyInfoCache[indexCache].warehouse[indexCache1], JSON.parse(JSON.stringify(child)))
                }
              })
            }
          } else if (key === 'bank') {
            // 更新账户信息
            if (type) {
              // 新增
              let newArr = [...target.new_bank]
              _.remove(newArr, (n) => {
                return moreInfoId === n.id
              })
              target.new_bank = newArr
              res.data.bank.map((child, i) => {
                let bankId = child.id
                let ifExit = _.find(target.bank, { id: bankId })
                child['editStatus'] = false
                child.other_info = JSON.parse(child.other_info)
                child.account_info.map((list, i) => {
                  list.other_info = JSON.parse(list.other_info)
                  this.$set(list.other_info, 'lists_new', [])
                  this.$set(list.other_info, 'list_id', 1)
                  list.other_info.lists.map((li, j) => {
                    this.$set(li, 'id', j + 1)
                  })
                })
                child.other_info.accounts.map((list, i) => {
                  this.$set(list, 'id', i + 1)
                })
                this.$set(child.other_info, 'accounts_new', [])
                this.$set(child.other_info, 'bank_id', 1)
                this.$set(child, 'account_info_new', [])
                this.$set(child, 'account_id', 1)
                if (!ifExit) {
                  target.bank.push(child)
                  targetCache.bank.push(JSON.parse(JSON.stringify(child)))
                }
              })
            } else {
              res.data.bank.map((child, i) => {
                child['editStatus'] = false
                if (child.id === moreInfoId) {
                  child['editStatus'] = false
                  child.other_info = JSON.parse(child.other_info)
                  child.account_info.map((list, i) => {
                    list.other_info = JSON.parse(list.other_info)
                    this.$set(list.other_info, 'lists_new', [])
                    this.$set(list.other_info, 'list_id', 1)
                    list.other_info.lists.map((li, j) => {
                      this.$set(li, 'id', j + 1)
                    })
                  })
                  child.other_info.accounts.map((list, i) => {
                    this.$set(list, 'id', i + 1)
                  })
                  this.$set(child.other_info, 'accounts_new', [])
                  this.$set(child.other_info, 'bank_id', 1)
                  this.$set(child, 'account_info_new', [])
                  this.$set(child, 'account_id', 1)
                  Object.assign(this.companyInfo[index].bank[index1], JSON.parse(JSON.stringify(child)))
                  Object.assign(this.companyInfoCache[indexCache].bank[indexCache1], JSON.parse(JSON.stringify(child)))
                }
              })
            }
          }
        }
      }).catch(error => {
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    cancelRegister (item) {
      // 取消编辑注册信息
      let target = item
      let targetCache = _.find(this.companyInfoCache, { id: item.id })
      if (_.isEqual(target.address, targetCache.address) && _.isEqual(target.company_tax_info, targetCache.company_tax_info) && _.isEqual(target.media, targetCache.media) && _.isEqual(target.contacts, targetCache.contacts) && target.new_tax.length === 0) {
        // 未做更改
        target.editStatus = false
        targetCache.editStatus = false
        this.canEdit = true
        return
      }
      this.editName = 'address'
      this.visibleSaveEdit = true
      this.editId = item.id
    },
    addOffice (item) {
      if (!this.canEdit) {
        return
      }
      item.new_office_id++
      let obj = { id: item.new_office_id, name: '', en_name: '', country: '', province: '', city: '', area: '', address: '', en_country: '', en_province: '', en_city: '', en_area: '', en_address: '', postcode: '', en_postcode: '', comment: '', contacts: [{ id: 1, type: 1, contacts: '', tel: '' }], en_contacts: [{ id: 1, type: 2, contacts: '', tel: '' }], media: [{ name: '', file: null }], contacts_new: [], contacts_id: 1, en_contacts_new: [], en_contacts_id: 1 }
      item.newOffice.push(obj)
      this.canEdit = false
      this.canEditID = item.id
    },
    changeOfficeValue (value, office, key) {
      office[key] = value
    },
    addOfficeContacts (office, type) {
      if (type === 1) {
        office.contacts_id++
        let contact = { id: office.contacts_id, type: type, contacts: '', tel: '' }
        office.contacts_new.push(contact)
      } else if (type === 2) {
        office.en_contacts_id++
        let contact1 = { id: office.en_contacts_id, type: type, contacts: '', tel: '' }
        office.en_contacts_new.push(contact1)
      }
    },
    deleteContact (id, office, type, status) {
      if (type === 1) {
        if (status) {
          // 删除新增的
          let newArr = [...office.contacts_new]
          _.remove(newArr, (n) => {
            return id === n.id
          })
          office.contacts_new = newArr
        } else {
          let newArr = [...office.contacts]
          _.remove(newArr, (n) => {
            return id === n.id
          })
          office.contacts = newArr
        }
      } else if (type === 2) {
        if (status) {
          let newArr1 = [...office.en_contacts_new]
          _.remove(newArr1, (n) => {
            return id === n.id
          })
          office.en_contacts_new = newArr1
        } else {
          let newArr1 = [...office.en_contacts]
          _.remove(newArr1, (n) => {
            return id === n.id
          })
          office.en_contacts = newArr1
        }
      }
    },
    saveOffice (item, officeId, type) {
      // type: 1为新增
      let index = _.findIndex(this.companyInfo, { id: item.id })
      let target = {}
      let targetCache = {}
      let flag1 = true
      if (type !== 1) {
        target = _.find(item.office, { id: officeId })
        targetCache = _.find(this.companyInfoCache[index].office, { id: officeId })
        if (_.isEqual(target, targetCache)) {
          this.$message.warning('未更改内容！')
          return
        }
      } else {
        target = _.find(item.newOffice, { id: officeId })
      }
      let text = (target.name === '' ? '公司名称、' : '') + (target.en_name === '' ? '外语名称、' : '') + (target.country === '' ? '注册国家、' : '') + (target.en_country === '' ? '外语注册国家、' : '') + (target.province === '' ? '注册省、' : '') + (target.en_province === '' ? '外语注册省、' : '') + (target.city === '' ? '注册市、' : '') + (target.en_city === '' ? '外语注册市、' : '') + (target.area === '' ? '注册区、' : '') + (target.en_area === '' ? '外语注册区、' : '') + (target.address === '' ? '注册详细地址、' : '') + (target.en_address === '' ? '外语注册详细地址、' : '') + (target.postcode === '' ? '注册邮编、' : '') + (target.en_postcode === '' ? '外语注册邮编' : '')
      if (target.name === '' || target.en_name === '' || target.country === '' || target.en_country === '' || target.province === '' || target.en_province === '' || target.city === '' || target.en_city === '' || target.area === '' || target.en_area === '' || target.address === '' || target.en_address === '' || target.postcode === '' || target.en_postcode === '') {
        this.$message.error(text + '不能为空')
        return
      }
      let pattern1 = new RegExp('[\u4e00-\u9fa5]')
      let text1 = (pattern1.test(target.en_name) ? '外语名称、' : '') + (pattern1.test(target.en_country) ? '外语注册国家、' : '') + (pattern1.test(target.en_province) ? '外语注册省、' : '') + (pattern1.test(target.en_city) ? '外语注册市、' : '') + (pattern1.test(target.en_area) ? '外语注册区、' : '') + (pattern1.test(target.en_address) ? '外语注册详细地址' : '')
      target.contacts.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.contacts_new.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.en_contacts.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.en_contacts_new.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      if (pattern1.test(target.en_name) || pattern1.test(target.en_country) || pattern1.test(target.en_province) || pattern1.test(target.en_city) || pattern1.test(target.en_area) || pattern1.test(target.en_address) || !flag1) {
        this.$message.error(text1 + (text1 ? '不能含中文' : '') + (!flag1 ? '一组联系人电话号码不能只填一个' : ''))
        return
      }
      this.visibleEdit = true
      this.editId = officeId
      this.editParentId = item.id
      this.editName = 'office'
      if (type) this.editType = type
    },
    cancelOffice (item, officeId, type) {
      let target = {}
      let targetCache = {}
      if (type === 1) {
        this.isNew = true
        target = _.find(item.newOffice, { id: officeId })
        targetCache = { id: item.new_office_id, name: '', en_name: '', country: '', province: '', city: '', area: '', address: '', en_country: '', en_province: '', en_city: '', en_area: '', en_address: '', postcode: '', en_postcode: '', comment: '', contacts: [{ id: 1, type: 1, contacts: '', tel: '' }], en_contacts: [{ id: 1, type: 2, contacts: '', tel: '' }], media: [{ name: '', file: null }], contacts_new: [], contacts_id: 1, en_contacts_new: [], en_contacts_id: 1 }
        if (_.isEqual(target, targetCache)) {
          let newArr = [...item.newOffice]
          _.remove(newArr, (n) => {
            return officeId === n.id
          })
          item.newOffice = newArr
          this.canEdit = true
          this.canEditID = -1
          return
        }
      } else {
        this.isNew = false
        target = _.find(item.office, { id: officeId })
        targetCache = _.find(_.find(this.companyInfoCache, { id: item.id }).office, { id: officeId })
        if (_.isEqual(target, targetCache)) {
          target.editStatus = false
          targetCache.editStatus = false
          this.canEdit = true
          this.canEditID = -1
          return
        }
      }
      this.editName = 'office'
      this.editId = officeId
      this.editParentId = item.id
      this.visibleSaveEdit = true
    },
    ifShow (checked, item, name, parentId) {
      this.visibleLogout = true
      this.logoutId = item.id
      this.logoutName = name
      this.logoutChecked = checked
      this.logoutText = checked ? '恢复' : '注销'
      this.logoutPlaceholder = '请输入' + this.logoutText + '原因'
      this.el = item
      this.editParentId = parentId
    },
    logoutOk () {
      let id = this.logoutId
      let name = this.logoutName === 'office' ? '办公室' : (this.logoutName === 'warehouse' ? '仓库地址' : '支付方式')
      let text = this.logoutChecked ? '恢复' : '注销'
      let comment = this.logoutReason
      let index = _.findIndex(this.companyInfo, { id: this.editParentId })
      let indexCache = _.findIndex(this.companyInfoCache, { id: this.editParentId })
      let index1 = _.findIndex(this.companyInfo[index][this.logoutName], { id: id })
      let indexCache1 = _.findIndex(this.companyInfoCache[indexCache][this.logoutName], { id: id })
      let form = new FormData()
      this.logoutLoading = true
      form.append('comment', comment)
      updateCompanyMoreInfoStatus(id, form, this.logoutName).then(res => {
        if (res.code === 200) {
          this.$message.success(name + text + '成功')
          this.companyInfo[index][this.logoutName][index1].status = this.logoutChecked ? 1 : 0
          this.companyInfoCache[index][this.logoutName][indexCache1].status = this.logoutChecked ? 1 : 0
          this.el.status = this.logoutChecked ? 1 : 0
          this.logoutLoading = false
          this.visibleLogout = false
          this.logoutText = ''
          this.logoutName = ''
          this.logoutPlaceholder = ''
          this.logoutId = -1
          this.logoutReason = ''
          this.logoutChecked = true
          this.el = ''
          this.editParentId = -1
        }
      }).catch(error => {
        this.logoutLoading = false
        this.$message.error(error.response ? error.response.data.message : error.message)
      })
    },
    logoutCancel () {
      this.visibleLogout = false
      this.logoutLoading = false
      this.logoutText = ''
      this.logoutName = ''
      this.logoutPlaceholder = ''
      this.logoutId = -1
      this.logoutReason = ''
      this.logoutChecked = true
      this.editParentId = -1
    },
    cancelEditOk () {
      let target = []
      let targetCache = []
      if (this.editParentId !== -1) {
        target = this.companyInfo.filter(list => this.editParentId === list.id)[0]
        targetCache = this.companyInfoCache.filter(list => this.editParentId === list.id)[0]
      }
      if (this.editName === 'address') {
        let item = _.find(this.companyInfo, { id: this.editId })
        let target = this.companyInfo.filter(list => item.id === list.id)[0]
        let targetCache = this.companyInfoCache.filter(list => item.id === list.id)[0]
        target.address = JSON.parse(JSON.stringify(targetCache.address))
        target.company_tax_info = JSON.parse(JSON.stringify(targetCache.company_tax_info))
        target.new_tax = []
        target.media = JSON.parse(JSON.stringify(targetCache.media))
        target.contacts = JSON.parse(JSON.stringify(targetCache.contacts))
        target.editStatus = false
        targetCache.editStatus = false

        this.visibleSaveEdit = false
        this.editName = ''
        this.editId = -1
        this.canEdit = true
      } else if (this.editName === 'office') {
        let id = this.editId
        if (this.isNew) {
          let newArr = [...target.newOffice]
          _.remove(newArr, (n) => {
            return id === n.id
          })
          target.newOffice = newArr
        } else {
          let newArr = [...target.office]
          let childCache = targetCache.office.filter(list => id === list.id)[0]
          target.office = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
          targetCache.office = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
        }
        this.visibleSaveEdit = false
        this.editName = ''
        this.isNew = true
        this.editId = -1
        this.editParentId = -1
        this.canEdit = true
        this.canEditID = -1
      } else if (this.editName === 'warehouse') {
        let id = this.editId
        if (this.isNew) {
          let newArr = [...target.new_warehouse]
          _.remove(newArr, (n) => {
            return id === n.id
          })
          target.new_warehouse = newArr
        } else {
          let newArr = [...target.warehouse]
          let childCache = targetCache.warehouse.filter(list => id === list.id)[0]
          target.warehouse = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
          targetCache.warehouse = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
        }
        this.visibleSaveEdit = false
        this.editName = ''
        this.isNew = true
        this.editId = -1
        this.editParentId = -1
        this.canEdit = true
        this.canEditID = -1
      } else if (this.editName === 'bank') {
        let id = this.editId
        if (this.isNew) {
          let newArr = [...target.new_bank]
          _.remove(newArr, (n) => {
            return id === n.id
          })
          target.new_bank = newArr
        } else {
          let newArr = [...target.bank]
          let childCache = targetCache.bank.filter(list => id === list.id)[0]
          target.bank = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
          targetCache.bank = newArr.map(list => {
            if (id === list.id) {
              childCache.editStatus = false
              list = JSON.parse(JSON.stringify(childCache))
            }
            return list
          })
        }
        this.visibleSaveEdit = false
        this.editName = ''
        this.isNew = true
        this.editId = -1
        this.editParentId = -1
        this.canEdit = true
        this.canEditID = -1
      }
    },
    cancelEditCancel () {
      this.visibleSaveEdit = false
      this.editName = ''
      this.isNew = true
      this.editId = -1
      this.editParentId = -1
      this.editName = ''
    },
    editOk () {
      if (this.editName === 'address') {
        // 编辑注册信息
        let id = this.editId
        let item = _.find(this.companyInfo, { id: id })
        let register = item.address
        let media = item.media
        let form = new FormData()
        form.append('name', register.name)
        form.append('en_name', register.en_name)
        form.append('country', register.country)
        form.append('province', register.province)
        form.append('city', register.city)
        form.append('area', register.area)
        form.append('address', register.address)
        form.append('tel', register.tel)
        form.append('en_country', register.en_country)
        form.append('en_province', register.en_province)
        form.append('en_city', register.en_city)
        form.append('en_area', register.en_area)
        form.append('en_address', register.en_address)
        form.append('en_tel', register.en_tel)
        form.append('contacts', item.contacts)
        media.forEach((value) => {
          if (value.isNew) {
            if (value.file) form.append('new_media[]', value.file)
          } else {
            form.append('old_media[]', value.id)
          }
        })
        item.company_tax_info.forEach((value, index) => {
          form.append('tax[' + index + '][country]', value.country)
          form.append('tax[' + index + '][tax_number]', value.tax_number)
          form.append('tax[' + index + '][id]', value.id)
        })
        item.new_tax.forEach((value, index) => {
          form.append('tax[' + (index + item.company_tax_info.length) + '][country]', value.country)
          form.append('tax[' + (index + item.company_tax_info.length) + '][tax_number]', value.tax_number)
        })
        this.editUpdateLoading = true
        updateCompanyRegistryInfo(id, form).then(res => {
          if (res.code === 200) {
            this.$message.success('编辑成功')
            this.updateInfo(id, 'address')
            this.editId = -1
            this.canEdit = true
            this.editUpdateLoading = false
            this.visibleEdit = false
            this.editName = ''
          }
        }).catch(error => {
          this.editUpdateLoading = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.editName === 'office') {
        // 编辑办公室信息
        let office = []
        let id = this.editParentId
        let type = this.editType
        let officeId = this.editId
        let item = _.find(this.companyInfo, { id: id })
        let form = new FormData()

        if (type === 1) {
          office = item.newOffice.filter(list => officeId === list.id)[0]
          let media = office.media
          media.forEach((value) => {
            if (value.file) form.append('new_media[]', value.file)
          })
          office.contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index) + '][type]', value.type)
              form.append('contacts[' + (index) + '][contacts]', value.contacts)
              form.append('contacts[' + (index) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          office.en_contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + office.contacts_new.length) + '][type]', value.type)
              form.append('contacts[' + (index + office.contacts_new.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + office.contacts_new.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
        } else {
          office = item.office.filter(list => officeId === list.id)[0]
          let media = office.media
          let oldMedia = []
          let newMedia = []
          media.forEach(list => {
            if (list.isNew) {
              if (list.file) newMedia.push(list)
            } else {
              oldMedia.push(list)
            }
          })
          form.append('id', officeId)
          if (oldMedia.length > 0) {
            oldMedia.forEach((value) => {
              form.append('old_media[]', value.id)
            })
          }
          if (newMedia.length > 0) {
            newMedia.forEach((value) => {
              form.append('new_media[]', value.file)
            })
          }
          office.contacts.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index) + '][id]', value.id)
              form.append('contacts[' + (index) + '][type]', value.type)
              form.append('contacts[' + (index) + '][contacts]', value.contacts)
              form.append('contacts[' + (index) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          office.contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + office.contacts.length) + '][type]', value.type)
              form.append('contacts[' + (index + office.contacts.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + office.contacts.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          office.en_contacts.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length) + '][id]', value.id)
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length) + '][type]', value.type)
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          office.en_contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length + office.en_contacts.length) + '][type]', value.type)
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length + office.en_contacts.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + office.contacts.length + office.contacts_new.length + office.en_contacts.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
        }
        form.append('name', office.name)
        form.append('en_name', office.en_name)
        form.append('country', office.country)
        form.append('province', office.province)
        form.append('city', office.city)
        form.append('area', office.area)
        form.append('address', office.address)
        form.append('postcode', office.postcode)
        form.append('en_country', office.en_country)
        form.append('en_province', office.en_province)
        form.append('en_city', office.en_city)
        form.append('en_area', office.en_area)
        form.append('en_address', office.en_address)
        form.append('en_postcode', office.en_postcode)
        form.append('comment', office.comment)
        this.editUpdateLoading = true
        updateCompanyOfficeInfo(id, form).then(res => {
          if (res.code === 200) {
            this.$message.success(type === 1 ? '新增成功' : '编辑成功')
            this.updateInfo(id, 'office', officeId, type)
            this.editUpdateLoading = false
            this.visibleEdit = false
            this.editId = -1
            this.editType = 0
            this.editParentId = -1
            this.editName = ''
            this.canEdit = true
            this.canEditID = -1
          }
        }).catch(error => {
          this.editUpdateLoading = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.editName === 'warehouse') {
        // 更新仓储地址信息
        let warehouse = []
        let id = this.editParentId
        let type = this.editType
        let warehouseId = this.editId
        let item = _.find(this.companyInfo, { id: id })
        let form = new FormData()

        if (type === 1) {
          warehouse = item.new_warehouse.filter(list => warehouseId === list.id)[0]
          let media = warehouse.media
          media.forEach((value) => {
            if (value.file) form.append('new_media[]', value.file)
          })
          warehouse.contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index) + '][type]', value.type)
              form.append('contacts[' + (index) + '][contacts]', value.contacts)
              form.append('contacts[' + (index) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          warehouse.en_contacts.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + warehouse.contacts_new.length) + '][type]', value.type)
              form.append('contacts[' + (index + warehouse.contacts_new.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + warehouse.contacts_new.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
        } else {
          warehouse = item.warehouse.filter(list => warehouseId === list.id)[0]
          let media = warehouse.media
          let oldMedia = []
          let newMedia = []
          media.forEach(list => {
            if (list.isNew) {
              if (list.file) newMedia.push(list)
            } else {
              oldMedia.push(list)
            }
          })
          form.append('id', warehouseId)
          if (oldMedia.length > 0) {
            oldMedia.forEach((value) => {
              form.append('old_media[]', value.id)
            })
          }
          if (newMedia.length > 0) {
            newMedia.forEach((value) => {
              form.append('new_media[]', value.file)
            })
          }
          warehouse.contacts.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index) + '][id]', value.id)
              form.append('contacts[' + (index) + '][type]', value.type)
              form.append('contacts[' + (index) + '][contacts]', value.contacts)
              form.append('contacts[' + (index) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          warehouse.contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + warehouse.contacts.length) + '][type]', value.type)
              form.append('contacts[' + (index + warehouse.contacts.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + warehouse.contacts.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          warehouse.en_contacts.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length) + '][id]', value.id)
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length) + '][type]', value.type)
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
          warehouse.en_contacts_new.forEach((value, index) => {
            if (value.contacts && value.tel) {
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length + warehouse.en_contacts.length) + '][type]', value.type)
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length + warehouse.en_contacts.length) + '][contacts]', value.contacts)
              form.append('contacts[' + (index + warehouse.contacts.length + warehouse.contacts_new.length + warehouse.en_contacts.length) + '][tel]', value.tel)
            } else if (!value.contacts && !value.tel) {} else {
              return false
            }
          })
        }
        form.append('name', warehouse.name)
        form.append('en_name', warehouse.en_name)
        form.append('country', warehouse.country)
        form.append('province', warehouse.province)
        form.append('city', warehouse.city)
        form.append('area', warehouse.area)
        form.append('address', warehouse.address)
        form.append('postcode', warehouse.postcode)
        form.append('en_country', warehouse.en_country)
        form.append('en_province', warehouse.en_province)
        form.append('en_city', warehouse.en_city)
        form.append('en_area', warehouse.en_area)
        form.append('en_address', warehouse.en_address)
        form.append('en_postcode', warehouse.en_postcode)
        form.append('comment', warehouse.comment)
        this.editUpdateLoading = true
        updateCompanyWarehouseInfo(id, form).then(res => {
          if (res.code === 200) {
            this.$message.success(type === 1 ? '新增成功' : '编辑成功')
            this.updateInfo(id, 'warehouse', warehouseId, type)
            this.editUpdateLoading = false
            this.visibleEdit = false
            this.editId = -1
            this.editType = 0
            this.editParentId = -1
            this.editName = ''
            this.canEdit = true
            this.canEditID = -1
          }
        }).catch(error => {
          this.editUpdateLoading = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (this.editName === 'bank') {
        // 更新账户信息
        let bank = []
        let id = this.editParentId
        let type = this.editType
        let bankId = this.editId
        let item = _.find(this.companyInfo, { id: id })
        let form = new FormData()

        if (type === 1) {
          bank = item.new_bank.filter(list => bankId === list.id)[0]
          let media = bank.media
          let otherInfo = { accounts: [] }
          bank.other_info.accounts_new.forEach((list) => {
            if (list.tit && list.con) otherInfo.accounts.push({ tit: list.tit, con: list.con })
          })
          media.forEach((value) => {
            if (value.file) form.append('new_media[]', value.file)
          })
          bank.account_info_new.forEach((value, index) => {
            let otherInfo1 = { lists: [] }
            value.other_info.lists_new.map((list) => {
              otherInfo1.lists.push({ tit: list.tit, con: list.con })
            })
            form.append('account_info[' + (index) + '][account_number]', value.account_number)
            form.append('account_info[' + (index) + '][currency]', value.currency)
            form.append('account_info[' + (index) + '][other_info]', JSON.stringify(otherInfo1))
          })
          form.append('other_info', JSON.stringify(otherInfo))
        } else {
          bank = item.bank.filter(list => bankId === list.id)[0]
          form.append('id', bankId)
          let media = bank.media
          let otherInfo = { accounts: [] }
          let oldMedia = []
          let newMedia = []
          bank.other_info.accounts.forEach((list) => {
            if (list.tit && list.con) otherInfo.accounts.push({ tit: list.tit, con: list.con })
          })
          bank.other_info.accounts_new.forEach((list) => {
            if (list.tit && list.con) otherInfo.accounts.push({ tit: list.tit, con: list.con })
          })
          media.forEach(list => {
            if (list.id) {
              if (list.file) oldMedia.push(list)
            } else {
              newMedia.push(list)
            }
          })
          if (oldMedia.length > 0) {
            oldMedia.forEach((value) => {
              form.append('old_media[]', value.id)
            })
          }
          if (newMedia.length > 0) {
            newMedia.forEach((value) => {
              form.append('new_media[]', value.file)
            })
          }
          bank.account_info.forEach((value, index) => {
            let otherInfo1 = { lists: [] }
            value.other_info.lists.map((list) => {
              otherInfo1.lists.push({ tit: list.tit, con: list.con })
            })
            value.other_info.lists_new.map((list) => {
              otherInfo1.lists.push({ tit: list.tit, con: list.con })
            })
            form.append('account_info[' + (index) + '][id]', value.id)
            form.append('account_info[' + (index) + '][account_number]', value.account_number)
            form.append('account_info[' + (index) + '][currency]', value.currency)
            form.append('account_info[' + (index) + '][other_info]', JSON.stringify(otherInfo1))
          })
          bank.account_info_new.forEach((value, index) => {
            let otherInfo1 = { lists: [] }
            value.other_info.lists_new.map((list) => {
              otherInfo1.lists.push({ tit: list.tit, con: list.con })
            })
            form.append('account_info[' + (index + bank.account_info.length) + '][account_number]', value.account_number)
            form.append('account_info[' + (index + bank.account_info.length) + '][currency]', value.currency)
            form.append('account_info[' + (index + bank.account_info.length) + '][other_info]', JSON.stringify(otherInfo1))
          })
          form.append('other_info', JSON.stringify(otherInfo))
        }
        form.append('pay_method', bank.pay_method)
        form.append('check_address', bank.check_address)
        form.append('comment', bank.comment)
        form.append('bank_name', bank.bank_name)
        form.append('account_name', bank.account_name)
        this.editUpdateLoading = true
        // return
        updateCompanyBankInfo(id, form).then(res => {
          if (res.code === 200) {
            this.$message.success(type === 1 ? '新增成功' : '编辑成功')
            this.updateInfo(id, 'bank', bankId, type)
            this.editUpdateLoading = false
            this.visibleEdit = false
            this.editId = -1
            this.editType = 0
            this.editParentId = -1
            this.editName = ''
            this.canEdit = true
            this.canEditID = -1
          }
        }).catch(error => {
          this.editUpdateLoading = false
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    editCancel () {
      this.visibleEdit = false
      this.editId = -1
      this.editType = 0
      this.editParentId = -1
      this.editName = ''
    },
    addWarehouse (item) {
      if (!this.canEdit) {
        return
      }
      item.new_warehouse_id++
      let obj = { id: item.new_warehouse_id, name: '', en_name: '', country: '', province: '', city: '', area: '', address: '', en_country: '', en_province: '', en_city: '', en_area: '', en_address: '', postcode: '', en_postcode: '', comment: '', contacts: [{ id: 1, type: 1, contacts: '', tel: '' }], en_contacts: [{ id: 1, type: 2, contacts: '', tel: '' }], media: [{ name: '', file: null }], contacts_new: [], contacts_id: 1, en_contacts_new: [], en_contacts_id: 1 }
      item.new_warehouse.push(obj)
      this.canEdit = false
      this.canEditID = item.id
    },
    saveWarehouse (item, warehouseId, type) {
      // type: 1为新增
      let index = _.findIndex(this.companyInfo, { id: item.id })
      let target = {}
      let targetCache = {}
      let flag1 = true
      if (type !== 1) {
        target = _.find(item.warehouse, { id: warehouseId })
        targetCache = _.find(this.companyInfoCache[index].warehouse, { id: warehouseId })
        if (_.isEqual(target, targetCache)) {
          this.$message.warning('未更改内容！')
          return
        }
      } else {
        target = _.find(item.new_warehouse, { id: warehouseId })
      }
      let text = (target.name === '' ? '公司名称、' : '') + (target.en_name === '' ? '外语名称、' : '') + (target.country === '' ? '注册国家、' : '') + (target.en_country === '' ? '外语注册国家、' : '') + (target.province === '' ? '注册省、' : '') + (target.en_province === '' ? '外语注册省、' : '') + (target.city === '' ? '注册市、' : '') + (target.en_city === '' ? '外语注册市、' : '') + (target.area === '' ? '注册区、' : '') + (target.en_area === '' ? '外语注册区、' : '') + (target.address === '' ? '注册详细地址、' : '') + (target.en_address === '' ? '外语注册详细地址、' : '') + (target.postcode === '' ? '注册邮编、' : '') + (target.en_postcode === '' ? '外语注册邮编' : '')
      if (target.name === '' || target.en_name === '' || target.country === '' || target.en_country === '' || target.province === '' || target.en_province === '' || target.city === '' || target.en_city === '' || target.area === '' || target.en_area === '' || target.address === '' || target.en_address === '' || target.postcode === '' || target.en_postcode === '') {
        this.$message.error(text + '不能为空')
        return
      }
      let pattern1 = new RegExp('[\u4e00-\u9fa5]')
      let text1 = (pattern1.test(target.en_name) ? '外语名称、' : '') + (pattern1.test(target.en_country) ? '外语注册国家、' : '') + (pattern1.test(target.en_province) ? '外语注册省、' : '') + (pattern1.test(target.en_city) ? '外语注册市、' : '') + (pattern1.test(target.en_area) ? '外语注册区、' : '') + (pattern1.test(target.en_address) ? '外语注册详细地址' : '')
      target.contacts.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.contacts_new.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.en_contacts.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      target.en_contacts_new.forEach((val, index, arr) => {
        if (val.contacts === '' && val.tel !== '') {
          flag1 = false
        } else if (val.contacts !== '' && val.tel === '') {
          flag1 = false
        }
      })
      if (pattern1.test(target.en_name) || pattern1.test(target.en_country) || pattern1.test(target.en_province) || pattern1.test(target.en_city) || pattern1.test(target.en_area) || pattern1.test(target.en_address) || !flag1) {
        this.$message.error(text1 + (text1 ? '不能含中文' : '') + (!flag1 ? '一组联系人电话号码不能只填一个' : ''))
        return
      }
      this.visibleEdit = true
      this.editId = warehouseId
      this.editParentId = item.id
      this.editName = 'warehouse'
      if (type) this.editType = type
    },
    cancelWarehouse (item, warehouseId, type) {
      let target = {}
      let targetCache = {}
      if (type === 1) {
        this.isNew = true
        target = _.find(item.new_warehouse, { id: warehouseId })
        targetCache = { id: item.new_warehouse_id, name: '', en_name: '', country: '', province: '', city: '', area: '', address: '', en_country: '', en_province: '', en_city: '', en_area: '', en_address: '', postcode: '', en_postcode: '', comment: '', contacts: [{ id: 1, type: 1, contacts: '', tel: '' }], en_contacts: [{ id: 1, type: 2, contacts: '', tel: '' }], media: [{ name: '', file: null }], contacts_new: [], contacts_id: 1, en_contacts_new: [], en_contacts_id: 1 }
        if (_.isEqual(target, targetCache)) {
          let newArr = [...item.new_warehouse]
          _.remove(newArr, (n) => {
            return warehouseId === n.id
          })
          item.new_warehouse = newArr
          this.canEdit = true
          this.canEditID = -1
          return
        }
      } else {
        this.isNew = false
        target = _.find(item.warehouse, { id: warehouseId })
        targetCache = _.find(_.find(this.companyInfoCache, { id: item.id }).warehouse, { id: warehouseId })
        if (_.isEqual(target, targetCache)) {
          target.editStatus = false
          targetCache.editStatus = false
          this.canEdit = true
          this.canEditID = -1
          return
        }
      }
      this.editName = 'warehouse'
      this.editId = warehouseId
      this.editParentId = item.id
      this.visibleSaveEdit = true
    },
    editWarehouse (warehouse, parentId) {
      if (!this.canEdit) {
        this.$message.warning('当前状态不可编辑其他内容！')
        return
      }
      let target = _.find(this.companyInfoCache, { id: parentId })
      let indexParent = _.findIndex(this.companyInfoCache, { id: parentId })
      let index = _.findIndex(target.warehouse, { id: warehouse.id })
      warehouse.editStatus = true
      this.companyInfoCache[indexParent].warehouse[index].editStatus = true
      this.canEdit = false
      this.canEditID = parentId
    },
    addAccount (item) {
      if (!this.canEdit) {
        return
      }
      item.new_bank_id++
      let bank = { id: item.new_bank_id, pay_method: '', check_address: '', comment: '', bank_name: '', account_name: '', other_info: { accounts_new: [{ id: 1, tit: '', con: '' }], bank_id: 1 }, account_info_new: [{ id: 1, account_number: '', currency: '', other_info: { lists_new: [{ id: 1, tit: '', con: '' }], list_id: 1 } }], media: [{ name: '', file: null }], account_id: 1 }
      item.new_bank.push(bank)
      this.canEdit = false
      this.canEditID = item.id
    },
    addBankInfo (bank) {
      bank.other_info.bank_id++
      let obj = { id: bank.other_info.bank_id, tit: '', con: '' }
      bank.other_info.accounts_new.push(obj)
    },
    deleteBankInfo (id, bank, type) {
      if (type === 1) {
        let newArr = [...bank.other_info.accounts_new]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        bank.other_info.accounts_new = newArr
      } else {
        let newArr = [...bank.other_info.accounts]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        bank.other_info.accounts = newArr
      }
    },
    addAccountList (account) {
      account.other_info.list_id++
      let obj = { id: account.other_info.list_id, tit: '', con: '' }
      account.other_info.lists_new.push(obj)
    },
    deleteAccountList (id, account, type) {
      if (type === 1) {
        let newArr = [...account.other_info.lists_new]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        account.other_info.lists_new = newArr
      } else {
        let newArr = [...account.other_info.lists]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        account.other_info.lists = newArr
      }
    },
    addAccountInfo (bank) {
      bank.account_id++
      let obj = { id: bank.account_id, account_number: '', currency: '', other_info: { lists_new: [{ id: 1, tit: '', con: '' }], list_id: 1 } }
      bank.account_info_new.push(obj)
    },
    deleteAccountInfo (bank, id, type) {
      if (type === 1) {
        let newArr = [...bank.account_info_new]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        bank.account_info_new = newArr
      } else {
        let newArr = [...bank.account_info]
        _.remove(newArr, (n) => {
          return id === n.id
        })
        bank.account_info = newArr
      }
    },
    saveBank (item, bankId, type) {
      let index = _.findIndex(this.companyInfo, { id: item.id })
      let target = {}
      let targetCache = {}
      let flag = true
      let flag1 = true
      if (type !== 1) {
        target = _.find(item.bank, { id: bankId })
        targetCache = _.find(this.companyInfoCache[index].bank, { id: bankId })
        if (_.isEqual(target, targetCache)) {
          this.$message.warning('未更改内容！')
          return
        }
      } else {
        target = _.find(item.new_bank, { id: bankId })
      }
      let text = (target.pay_method === '' ? '收款方式、' : '') + (target.bank_name === '' ? 'Bank Name、' : '') + (target.account_name === '' ? 'Account Name、' : '')
      let textCache = ''
      if (type !== 1) {
        target.account_info.forEach((val, index, arr) => {
          if (val.account_number === '' || val.currency === '') {
            textCache = (val.currency === '' ? '账号信息币种、' : '') + (val.account_number === '' ? '账号信息Account Number' : '')
            flag = false
          }
        })
        target.account_info_new.forEach((val, index, arr) => {
          if (val.account_number === '' || val.currency === '') {
            textCache = (val.currency === '' ? '账号信息币种、' : '') + (val.account_number === '' ? '账号信息Account Number' : '')
            flag = false
          }
        })
        target.other_info.accounts.forEach((val, index, arr) => {
          if (val.con === '' && val.tit !== '') {
            flag1 = false
          } else if (val.con !== '' && val.tit === '') {
            flag1 = false
          }
        })
        target.other_info.accounts_new.forEach((val, index, arr) => {
          if (val.con === '' && val.tit !== '') {
            flag1 = false
          } else if (val.con !== '' && val.tit === '') {
            flag1 = false
          }
        })
        text += textCache
        if (target.pay_method === '' || target.bank_name === '' || target.account_name === '' || !flag || !flag1) {
          this.$message.error(text + (text ? '不能为空；' : '') + (!flag1 ? '银行信息一组标题内容不能只填一个' : ''))
          flag = true
          return
        }
      } else {
        target.account_info_new.forEach((val, index, arr) => {
          if (val.account_number === '' || val.currency === '') {
            textCache = (val.currency === '' ? '账号信息币种、' : '') + (val.account_number === '' ? '账号信息Account Number' : '')
            flag = false
          }
        })
        target.other_info.accounts_new.forEach((val, index, arr) => {
          if (val.con === '' && val.tit !== '') {
            flag1 = false
          } else if (val.con !== '' && val.tit === '') {
            flag1 = false
          }
        })
        text += textCache
        if (target.pay_method === '' || target.bank_name === '' || target.account_name === '' || !flag || !flag1) {
          this.$message.error(text + (text ? '不能为空；' : '') + (!flag1 ? '银行信息一组标题内容不能只填一个' : ''))
          flag = true
          return
        }
      }
      this.visibleEdit = true
      this.editId = bankId
      this.editParentId = item.id
      this.editName = 'bank'
      if (type) this.editType = type
    },
    cancelBank (item, bankId, type) {
      let target = {}
      let targetCache = {}
      if (type === 1) {
        this.isNew = true
        target = _.find(item.new_bank, { id: bankId })
        let targetCache = { id: item.new_bank_id, pay_method: '', check_address: '', comment: '', bank_name: '', account_name: '', other_info: { accounts_new: [{ id: 1, tit: '', con: '' }], bank_id: 1 }, account_info_new: [{ id: 1, account_number: '', currency: '', other_info: { lists_new: [{ id: 1, tit: '', con: '' }], list_id: 1 } }], media: [{ name: '', file: null }], account_id: 1 }
        if (_.isEqual(target, targetCache)) {
          let newArr = [...item.new_bank]
          _.remove(newArr, (n) => {
            return bankId === n.id
          })
          item.new_bank = newArr
          this.canEdit = true
          this.canEditID = -1
          return
        }
      } else {
        this.isNew = false
        target = _.find(item.bank, { id: bankId })
        targetCache = _.find(_.find(this.companyInfoCache, { id: item.id }).bank, { id: bankId })
        if (_.isEqual(target, targetCache)) {
          target.editStatus = false
          targetCache.editStatus = false
          this.canEdit = true
          this.canEditID = -1
          return
        }
      }
      this.editName = 'bank'
      this.editId = bankId
      this.editParentId = item.id
      this.visibleSaveEdit = true
    },
    editBank (bank, parentId) {
      if (!this.canEdit) {
        this.$message.warning('当前状态不可编辑其他内容！')
        return
      }
      let target = _.find(this.companyInfoCache, { id: parentId })
      let indexParent = _.findIndex(this.companyInfoCache, { id: parentId })
      let index = _.findIndex(target.bank, { id: bank.id })
      bank.editStatus = true
      this.companyInfoCache[indexParent].bank[index].editStatus = true
      this.canEdit = false
      this.canEditID = parentId
    },
    statusLogCancel () {
      this.visibleStatusLog = false
      this.listLog = []
    },
    showStatusLog (id, key) {
      if (key === 'office') {
        if (!canDo('company.office.statusLogs')) {
          return
        }
        getCompanyOfficeStatusLog(id).then(res => {
          if (res.code === 200) {
            this.visibleStatusLog = true
            this.listLog = res.data.logs
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (key === 'warehouse') {
        if (!canDo('company.warehouse.statusLogs')) {
          return
        }
        getCompanyWarehouseStatusLog(id).then(res => {
          if (res.code === 200) {
            this.visibleStatusLog = true
            this.listLog = res.data.logs
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      } else if (key === 'bank') {
        if (!canDo('company.bank.statusLogs')) {
          return
        }
        getCompanyBankStatusLog(id).then(res => {
          if (res.code === 200) {
            this.visibleStatusLog = true
            this.listLog = res.data.logs
          }
        }).catch(error => {
          this.$message.error(error.response ? error.response.data.message : error.message)
        })
      }
    },
    filterOption (input, option) {
      return (
        option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      )
    }
  }
}
</script>
<style lang="less" scoped>
  .table-2 {
    thead td {line-height: 26px;}
  }
  .marginB9 {margin-bottom: 9px;}
  .mgB8 {margin-bottom: 8px;}

  .company-box {
    background:rgba(255,255,255,1);
    box-shadow:0px 5px 15px 0px rgba(223,226,230,0.8);
    border-radius:5px;
    margin-top: 20px;
    color: #666;
    line-height: 15px;

    table {
      table-layout: fixed;

      td {
        word-break: break-all;
        word-wrap: break-word;
        padding: 0 20px;
      }
    }
    .c-content {
      padding: 20px 0 27px;
    }
    .c-content-edit {
      padding: 20px 10px 27px 0;
    }
    .c-tit {
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 16px;

      .c-num {color: #378EEF;margin-right: 4px;}
    }
    .p-tip-b {
      margin-left: 4px;
      top: 1px;
      font-weight: normal;

      .iconshiyi {
        font-size: 12px;
      }
    }
    .c-list {
      margin-bottom: 16px;
      position: relative;
      min-height: 15px;

      .iconliebiaofujian {
        font-size: 12px;
        color: #378EEF;
      }
    }
    .c-status {
      font-size: 12px;
    }
    .c-little-tit {
      position: absolute;
      left: 0;
      top: 0;
      color: #bbb;
    }
    .more-btn {
      position: absolute;
      right: 0;
      top: 0;
      color: #378EEF;
      cursor: pointer;
    }
    .edit-btn {
      color: #378EEF;
      cursor: pointer;

      .iconbianji {
        font-size: 12px;
        margin-right: 4px;
      }
    }
    .companyInfo-more {
      background-color: #f9f9f9;
      border: 1px solid #eee;
      position: relative;
    }
    .companyInfo-more::after {
      position: absolute;
      content: '';
      display: block;
      width: 21px;
      height: 12px;
      background: url(../../../assets/images/uums-icon.png) no-repeat -57px -12px;
      top: -11px;
      right: 45px;
    }
    .left-part {
      padding-top: 12px;
    }
    .right-part {
      position: relative;

      >ul>li {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 20px;
      }
      >ul>li:last-child {
        border-bottom: 0;
        padding-bottom: 0px;
        margin-bottom: 0;
      }
      >ul>li.not-last {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 20px;
      }
    }
    .right-part::after {
      content: '';
      display: block;
      position: absolute;
      height: 100%;
      width: 1px;
      left: -60px;
      top: 0;
      background-color: #eee;
    }
    .part-tit {
      margin-bottom: 18px;

      >b {
        font-weight: bold;
        display: block;
        line-height: 13px;
        border-right: 1px solid #eee;
        padding-right: 10px;
        float: left;
        margin-right: 10px;
        margin-top: 1px;
      }
    }
    .add-info {
      width: 15px;
      height: 15px;
      border-radius: 50%;
      background: url(../../../assets/images/uums-icon.png) no-repeat -32px -10px;
      cursor: pointer;
    }
    .add-info.disabled {
      background-position-x: -88px;
      cursor: not-allowed;
    }
    .officeAddress {
      width: 44px;
      height: 35px;
      background: url(../../../assets/images/uums-icon.png) no-repeat -10px -42px;
    }
    .warehouseAddress {
      width: 42px;
      height: 42px;
      background: url(../../../assets/images/uums-icon.png) no-repeat -74px -35px;
    }
    .bankAccount {
      width: 44px;
      height: 30px;
      background: url(../../../assets/images/uums-icon.png) no-repeat -136px -47px;
    }
    .add-btn {
      color: #378EEF;
      float: right;

      .iconxinzeng {
        font-size: 12px;
      }
    }
    .identifier-box {
      position: relative;
      margin-bottom: 10px;;

      .iconshanchu1 {
        position: absolute;
        right: 0;
        top: 10px;
        cursor: pointer;
        font-size: 12px;
        color: #BBBBBB;
        transform: scale(.83333);
      }
    }
    /deep/ .ant-checkbox + span {
      padding: 0 0 0 3px;
      font-size: 12px;
    }
    /deep/ .switch-btn {
      background-color: #bbb;
      min-width: 24px;
      width: 28px;
      height: 14px;
    }
    /deep/ .switch-btn.ant-switch-checked {
      background-color: #3ecca6;
    }
    /deep/ .switch-btn:after {
      width: 10px;
      height: 10px;
    }
  }
  .save-btn {
    width: 68px;
    text-align: center;
    line-height: 34px;
    color: #fff;
    background-color: #378EEF;
    border-radius: 3px;
    font-size: 14px;
    margin-right: 20px;
    cursor: pointer;
  }
  .cancel-btn {
    width: 68px;
    text-align: center;
    line-height: 32px;
    color: #666;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
    cursor: pointer;
  }
  .save-btn:hover,.cancel-btn:hover {opacity: .9;}
  .no-data {
    line-height: 32px;
    color: #bbb;
  }
  .tip-modal {
    .tip-txt {
      text-align: center;
      padding: 30px 0 22px;
      font-size: 16px;
    }
  }
  .account-info {
    position: relative;
    padding: 32px 30px 0 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;

    .account-list {
      position: relative;
      margin-bottom: 10px;

      .iconfont {
        position: absolute;
        font-size: 14px;
        right: -20px;
        top: 8px;
        color: #378EEF;
        cursor: pointer;
      }
    }
    >.iconshanchu1 {
      position: absolute;
      right: 10px;
      top: 10px;
      color: #bbb;
      font-size: 12px;
      cursor: pointer;
      transform: scale(.83);
    }
  }
  .account-info-list.need-br::after {
    width: 100%;
    float: left;
  }
</style>
<style lang="less">
.company-status-log {
  .ant-modal-body {
    padding: 0 20px 20px;
  }
  .ant-table-body {
    margin-top: 6px;
  }
}
</style>
