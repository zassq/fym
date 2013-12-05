(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['row'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n<tr>\r\n	<td>\r\n		";
  stack1 = helpers['if'].call(depth0, (depth0 && depth0.existed_client), {hash:{},inverse:self.program(4, program4, data),fn:self.program(2, program2, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n	</td>\r\n	<td>\r\n		";
  stack1 = helpers['if'].call(depth0, (depth0 && depth0.existed_client), {hash:{},inverse:self.program(8, program8, data),fn:self.program(6, program6, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n	</td>\r\n	<td>\r\n		";
  stack1 = helpers.compare.call(depth0, (depth0 && depth0.is_hightech), "Y", {hash:{},inverse:self.noop,fn:self.program(10, program10, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n		";
  stack1 = helpers.compare.call(depth0, (depth0 && depth0.is_hightech), "N", {hash:{},inverse:self.noop,fn:self.program(8, program8, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n	</td>\r\n	<td>\r\n	balabala\r\n	</td>\r\n</tr>\r\n";
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n		<a href=\"/client/";
  if (stack1 = helpers.client_id) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = (depth0 && depth0.client_id); stack1 = typeof stack1 === functionType ? stack1.call(depth0, {hash:{},data:data}) : stack1; }
  buffer += escapeExpression(stack1)
    + "\">";
  if (stack1 = helpers.company_name) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = (depth0 && depth0.company_name); stack1 = typeof stack1 === functionType ? stack1.call(depth0, {hash:{},data:data}) : stack1; }
  buffer += escapeExpression(stack1)
    + "</a>\r\n		";
  return buffer;
  }

function program4(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n		";
  if (stack1 = helpers.company_name) { stack1 = stack1.call(depth0, {hash:{},data:data}); }
  else { stack1 = (depth0 && depth0.company_name); stack1 = typeof stack1 === functionType ? stack1.call(depth0, {hash:{},data:data}) : stack1; }
  buffer += escapeExpression(stack1)
    + "\r\n		";
  return buffer;
  }

function program6(depth0,data) {
  
  
  return "\r\n		<span class=\"text-success\">是</span>\r\n		";
  }

function program8(depth0,data) {
  
  
  return "\r\n		<span class=\"text-danger\">否</span>\r\n		";
  }

function program10(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n			<span class=\"text-success\">是</span>\r\n			";
  stack1 = helpers['if'].call(depth0, (depth0 && depth0.hightech_cert_code), {hash:{},inverse:self.noop,fn:self.program(11, program11, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n			";
  stack1 = helpers['if'].call(depth0, (depth0 && depth0.soft_comp_cert_code), {hash:{},inverse:self.noop,fn:self.program(13, program13, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\r\n		";
  return buffer;
  }
function program11(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n				<br />\r\n				<span class=\"small text-muted\">高新证书："
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.hightech_cert_code)),stack1 == null || stack1 === false ? stack1 : stack1['H'])),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\r\n			";
  return buffer;
  }

function program13(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\r\n				<br />\r\n				<span class=\"small text-muted\">软企证书："
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.soft_comp_cert_code)),stack1 == null || stack1 === false ? stack1 : stack1['S'])),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\r\n			";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.files), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });
})();