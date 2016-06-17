<%@ WebHandler Language="C#" Class="userAuth" %>

public class userAuth : IHttpHandler
{
    public void ProcessRequest(HttpContext context)
    {
 
        var appid = "wxbcb7a1667c4626a0";
        var secret = "54993b45494154d19785645f88a9b14b";

        var code = context.Request.QueryString["Code"];
        if (string.IsNullOrEmpty(code))
        {
            var url = string.Format("https://open.weixin.qq.com/connect/oauth2/authorize?appid={0}&redirect_uri=http%3a%2f%2f119.29.92.150%2fuserAuth.ashx&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect", appid);
            context.Response.Redirect(url);
        }
        else
        {
            var client = new System.Net.WebClient();
            client.Encoding = System.Text.Encoding.UTF8;

            var url = string.Format("https://api.weixin.qq.com/sns/oauth2/access_token?appid={0}&secret={1}&code={2}&grant_type=authorization_code", appid, secret, code);
            var data = client.DownloadString(url);

            var serializer = new JavaScriptSerializer();
            var obj = serializer.Deserialize<Dictionary<string, string>>(data);
            string accessToken;
            if (!obj.TryGetValue("access_token", out accessToken))
                return;

            var opentid = obj["openid"];
            url = string.Format("https://api.weixin.qq.com/sns/userinfo?access_token={0}&openid={1}&lang=zh_CN", accessToken, opentid);
            data = client.DownloadString(url);
            var userInfo = serializer.Deserialize<Dictionary<string, object>>(data);
            foreach (var key in userInfo.Keys)
            {
                context.Response.Write(string.Format("{0}: {1}", key, userInfo[key]) + "<br/>");
            }
        }
    }
}